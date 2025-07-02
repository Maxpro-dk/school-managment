<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Dashboard;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Schedule;
use Database\Seeders\BeninSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Exécuter le seeder pour avoir des données de test
        $this->seed(BeninSchoolSeeder::class);
    }

    #[Test]
    public function it_displays_correct_total_counts()
    {
        Livewire::test(Dashboard::class)
            ->assertSet('totalStudents', Student::count())
            ->assertSet('totalTeachers', Teacher::count())
            ->assertSet('totalClasses', SchoolClass::count())
            ->assertSet('totalSubjects', Subject::count())
            ->assertViewHas('totalStudents', function ($value) {
                return $value > 0; // Vérifie qu'il y a des étudiants
            })
            ->assertViewHas('totalTeachers', 20) // Le seeder crée 20 enseignants
            ->assertViewHas('totalSubjects', 10); // Le seeder crée 10 matières
    }

    #[Test]
    public function it_loads_classes_with_most_students()
    {
        Livewire::test(Dashboard::class)
            ->assertSet('classesWithMostStudents', function ($classes) {
                // Vérifie que nous avons au maximum 5 classes
                $this->assertLessThanOrEqual(5, $classes->count());
                
                // Vérifie que les classes sont triées par nombre d'étudiants (décroissant)
                if ($classes->count() > 1) {
                    $firstClassCount = $classes->first()->students_count;
                    $lastClassCount = $classes->last()->students_count;
                    $this->assertGreaterThanOrEqual($lastClassCount, $firstClassCount);
                }
                
                return true;
            });
    }

    #[Test]
    public function it_renders_students_per_class_grouped_by_level()
    {
        $component = Livewire::test(Dashboard::class);
        
        $component->assertViewHas('studentsPerClass', function ($studentsPerClass) {
            // Vérifie que les données sont groupées par niveau
            $expectedLevels = ['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'];
            
            foreach ($expectedLevels as $level) {
                $this->assertArrayHasKey($level, $studentsPerClass->toArray());
            }
            
            // Vérifie que chaque niveau a des classes avec des étudiants
            foreach ($studentsPerClass as $level => $classes) {
                $this->assertGreaterThan(0, $classes->count());
                
                foreach ($classes as $class) {
                    $this->assertGreaterThan(0, $class->student_count);
                    $this->assertNotNull($class->teacher); // Vérifie la relation teacher
                }
            }
            
            return true;
        });
    }

}