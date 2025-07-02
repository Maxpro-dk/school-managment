<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ClassDetails;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Schedule;
use Database\Seeders\BeninSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClassDetailsTest extends TestCase
{
    use RefreshDatabase;

    protected $schoolClass;
    protected $teacher;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Exécuter le seeder pour avoir des données complètes
        $this->seed(BeninSchoolSeeder::class);
        
        // Récupérer une classe existante créée par le seeder
        $this->schoolClass = SchoolClass::with(['teacher', 'students', 'schedules'])
            ->first();
        
        $this->teacher = $this->schoolClass->teacher;
    }

    #[Test]
    public function it_loads_class_data_correctly_on_mount()
    {
        $expectedStudentCount = $this->schoolClass->students->count();
        $expectedSubjectCount = $this->schoolClass->schedules->pluck('subject_id')->unique()->count();
        
        Livewire::test(ClassDetails::class, ['classId' => $this->schoolClass->id])
            ->assertSet('classId', $this->schoolClass->id)
            ->assertSet('totalStudents', $expectedStudentCount)
            ->assertSet('subjectsCount', $expectedSubjectCount)
            ->assertViewHas('schoolClass', function ($schoolClass) {
                $this->assertEquals($this->schoolClass->id, $schoolClass->id);
                $this->assertEquals($this->schoolClass->name, $schoolClass->name);
                $this->assertEquals($this->schoolClass->level, $schoolClass->level);
                $this->assertEquals('2024-2025', $schoolClass->academic_year);
                return true;
            })
            ->assertViewHas('classTeacher', function ($teacher) {
                $this->assertEquals($this->teacher->id, $teacher->id);
                $this->assertNotEmpty($teacher->first_name);
                $this->assertNotEmpty($teacher->last_name);
                return true;
            });
    }

    #[Test]
    public function it_displays_students_correctly()
    {
        $expectedStudentCount = $this->schoolClass->students->count();
        
        Livewire::test(ClassDetails::class, ['classId' => $this->schoolClass->id])
            ->assertViewHas('students', function ($students) use ($expectedStudentCount) {
                $this->assertEquals($expectedStudentCount, $students->count());
                $this->assertGreaterThanOrEqual(25, $students->count()); // Le seeder crée 25-35 étudiants par classe
                
                // Vérifie que tous les étudiants appartiennent à cette classe
                foreach ($students as $student) {
                    $this->assertEquals($this->schoolClass->id, $student->school_class_id);
                }
                return true;
            })
            ->assertViewHas('totalStudents', $expectedStudentCount);
    }

    #[Test]
    public function it_organizes_weekly_schedule_correctly()
    {
        Livewire::test(ClassDetails::class, ['classId' => $this->schoolClass->id])
            ->assertViewHas('weeklySchedule', function ($weeklySchedule) {
                // Vérifie que le planning est groupé par jour
                $this->assertInstanceOf(\Illuminate\Support\Collection::class, $weeklySchedule);
                
                // Vérifie que nous avons des jours de la semaine (le seeder crée lundi-samedi)
                $expectedDays = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                foreach ($expectedDays as $day) {
                    if ($weeklySchedule->has($day)) {
                        // Vérifie que les cours du jour sont triés par heure de début
                        $daySchedule = $weeklySchedule->get($day);
                        if ($daySchedule->count() > 1) {
                            $previousTime = null;
                            foreach ($daySchedule as $schedule) {
                                if ($previousTime) {
                                    $this->assertTrue($schedule->start_time >= $previousTime);
                                }
                                $previousTime = $schedule->start_time;
                            }
                        }
                    }
                }
                return true;
            })
            ->assertViewHas('weekDays', function ($weekDays) {
                // Vérifie que les jours de la semaine sont correctement définis
                $expectedDays = [
                    'lundi' => 'Lundi',
                    'mardi' => 'Mardi',
                    'mercredi' => 'Mercredi',
                    'jeudi' => 'Jeudi',
                    'vendredi' => 'Vendredi',
                    'samedi' => 'Samedi'
                ];
                $this->assertEquals($expectedDays, $weekDays);
                return true;
            });
    }

    #[Test]
    public function it_handles_class_not_found_exception()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        
        Livewire::test(ClassDetails::class, ['classId' => 99999]);
    }

    #[Test]
    public function it_calculates_subjects_count_correctly()
    {
        // Utiliser une classe existante du seeder
        $testClass = SchoolClass::with('schedules')->first();
        
        // Calculer manuellement le nombre de matières distinctes
        $expectedSubjectsCount = $testClass->schedules->pluck('subject_id')->unique()->count();

        Livewire::test(ClassDetails::class, ['classId' => $testClass->id])
            ->assertSet('subjectsCount', $expectedSubjectsCount)
            ->assertViewHas('subjectsCount', function ($subjectsCount) use ($expectedSubjectsCount) {
                $this->assertEquals($expectedSubjectsCount, $subjectsCount);
                $this->assertGreaterThan(0, $subjectsCount); // Au moins une matière
                return true;
            });
    }
}