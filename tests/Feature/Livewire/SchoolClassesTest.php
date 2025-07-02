<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\SchoolClasses;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Database\Seeders\BeninSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SchoolClassesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Exécuter le seeder pour avoir des données de test
        $this->seed(BeninSchoolSeeder::class);
    }

    #[Test]
    public function it_displays_classes_and_handles_search()
    {
        Livewire::test(SchoolClasses::class)
            ->assertViewHas('classes', function ($classes) {
                // Vérifie qu'il y a des classes (le seeder crée 12 classes : 6 niveaux × 2 sections)
                $this->assertGreaterThan(0, $classes->count());
                return true;
            })
            ->set('search', 'CI')
            ->assertViewHas('classes', function ($classes) {
                // Vérifie que la recherche fonctionne (devrait trouver CI-A et CI-B)
                $this->assertGreaterThan(0, $classes->count());
                foreach ($classes as $class) {
                    $this->assertTrue(
                        str_contains($class->name, 'CI') || 
                        str_contains($class->level, 'CI') ||
                        str_contains($class->academic_year, 'CI')
                    );
                }
                return true;
            });
    }

    #[Test]
    public function it_can_create_new_class()
    {
        $teacher = Teacher::first();
        
        Livewire::test(SchoolClasses::class)
            ->call('create')
            ->assertSet('showModal', true)
            ->assertSet('editMode', false)
            ->set('name', 'CE1-C')
            ->set('level', 'CE1')
            ->set('academic_year', '2024-2025')
            ->set('teacher_id', $teacher->id)
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que la classe a été créée en base
        $this->assertDatabaseHas('school_classes', [
            'name' => 'CE1-C',
            'level' => 'CE1',
            'academic_year' => '2024-2025',
            'teacher_id' => $teacher->id,
        ]);
    }

    #[Test]
    public function it_can_edit_existing_class()
    {
        $class = SchoolClass::first();
        $teacher = Teacher::skip(1)->first(); // Prendre un autre enseignant
        
        Livewire::test(SchoolClasses::class)
            ->call('edit', $class->id)
            ->assertSet('showModal', true)
            ->assertSet('editMode', true)
            ->assertSet('classId', $class->id)
            ->assertSet('name', $class->name)
            ->assertSet('level', $class->level)
            ->set('name', 'CP-C')
            ->set('teacher_id', $teacher->id)
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que la classe a été mise à jour
        $this->assertDatabaseHas('school_classes', [
            'id' => $class->id,
            'name' => 'CP-C',
            'teacher_id' => $teacher->id,
        ]);
    }

    #[Test]
    public function it_validates_form_data_correctly()
    {
        Livewire::test(SchoolClasses::class)
            ->call('create')
            ->set('name', '') // Nom vide
            ->set('level', 'INVALID') // Niveau invalide
            ->set('academic_year', '2024') // Format invalide
            ->set('teacher_id', 9999) // Enseignant inexistant
            ->call('save')
            ->assertHasErrors([
                'name' => 'required',
                'level' => 'in',
                'academic_year' => 'regex',
                'teacher_id' => 'exists'
            ])
            ->assertSet('showModal', true); // Le modal reste ouvert en cas d'erreur

        // Vérifie qu'aucune classe n'a été créée
        $this->assertDatabaseMissing('school_classes', [
            'name' => '',
        ]);
    }
}