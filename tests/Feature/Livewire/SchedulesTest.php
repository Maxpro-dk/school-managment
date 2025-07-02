<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Schedules;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use Database\Seeders\BeninSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SchedulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Exécuter le seeder pour avoir des données de test
        $this->seed(BeninSchoolSeeder::class);
    }

    #[Test]
    public function it_displays_schedules()
    {
        Livewire::test(Schedules::class)
            ->assertViewHas('schedules', function ($schedules) {
                // Vérifie qu'il y a des emplois du temps (le seeder crée des emplois du temps pour chaque classe)
                $this->assertGreaterThan(0, $schedules->count());
                return true;
            });
          
    }

    #[Test]
    public function it_can_create_new_schedule()
    {
        $class = SchoolClass::first();
        $subject = Subject::first();
        
        Livewire::test(Schedules::class)
            ->call('create')
            ->assertSet('showModal', true)
            ->assertSet('editMode', false)
            ->set('school_class_id', $class->id)
            ->set('subject_id', $subject->id)
            ->set('day', 'lundi')
            ->set('start_time', '14:00:00')
            ->set('end_time', '15:00:00')
            ->call('save');

        // Vérifie que l'emploi du temps a été créé en base
        $this->assertDatabaseHas('schedules', [
            'school_class_id' => $class->id,
            'subject_id' => $subject->id,
            'day' => 'lundi',
        ]);
    }

    #[Test]
    public function it_can_edit_existing_schedule()
    {
        $schedule = Schedule::first();
        $newClass = SchoolClass::where('id', '!=', $schedule->school_class_id)->first();
        $newSubject = Subject::where('id', '!=', $schedule->subject_id)->first();
        
        Livewire::test(Schedules::class)
            ->call('edit', $schedule->id)
            ->assertSet('showModal', true)
            ->assertSet('editMode', true)
            ->assertSet('scheduleId', $schedule->id)
            ->assertSet('school_class_id', $schedule->school_class_id)
            ->assertSet('subject_id', $schedule->subject_id)
            ->assertSet('day', $schedule->day)
            ->set('school_class_id', $newClass->id)
            ->set('subject_id', $newSubject->id)
            ->set('day', 'mardi')
            ->set('start_time', '13:00')
            ->set('end_time', '14:00')
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que l'emploi du temps a été mis à jour
        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'school_class_id' => $newClass->id,
            'subject_id' => $newSubject->id,
            'day' => 'mardi'
        ]);
    }

    #[Test]
    public function it_validates_form_data_correctly()
    {
        Livewire::test(Schedules::class)
            ->call('create')
            ->set('school_class_id', 9999) // Classe inexistante
            ->set('subject_id', 9999) // Matière inexistante
            ->set('day', 'dimanche') // Jour invalide
            ->set('start_time', '25:00') // Heure invalide
            ->set('end_time', '10:00') // Heure de fin avant heure de début
            ->call('save')
            ->assertHasErrors([
                'school_class_id' => 'exists',
                'subject_id' => 'exists',
                'day' => 'in',
                'start_time' => 'date_format',
                'end_time' => 'after'
            ])
            ->assertSet('showModal', true); // Le modal reste ouvert en cas d'erreur

        // Test avec des champs vides
        Livewire::test(Schedules::class)
            ->call('create')
            ->set('school_class_id', '')
            ->set('subject_id', '')
            ->set('day', '')
            ->set('start_time', '')
            ->set('end_time', '')
            ->call('save')
            ->assertHasErrors([
                'school_class_id' => 'required',
                'subject_id' => 'required',
                'day' => 'required',
                'start_time' => 'required',
                'end_time' => 'required'
            ]);

        // Test avec une heure de fin avant l'heure de début
        $class = SchoolClass::first();
        $subject = Subject::first();
        
        Livewire::test(Schedules::class)
            ->call('create')
            ->set('school_class_id', $class->id)
            ->set('subject_id', $subject->id)
            ->set('day', 'lundi')
            ->set('start_time', '15:00')
            ->set('end_time', '14:00') // Avant l'heure de début
            ->call('save')
            ->assertHasErrors(['end_time' => 'after']);
    }
}