<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Subjects;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubjectsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer quelques matières de test
        Subject::factory()->create([
            'name' => 'Mathématiques',
            'code' => 'MATH',
            'description' => 'Matière de mathématiques'
        ]);
        
        Subject::factory()->create([
            'name' => 'Français',
            'code' => 'FRAN',
            'description' => 'Matière de français'
        ]);
        
        Subject::factory()->create([
            'name' => 'Sciences Physiques',
            'code' => 'PHYS',
            'description' => 'Matière de sciences physiques'
        ]);
    }

    #[Test]
    public function it_displays_subjects_and_handles_search()
    {
        Livewire::test(Subjects::class)
            ->assertViewHas('subjects', function ($subjects) {
                // Vérifie qu'il y a des matières
                $this->assertGreaterThan(0, $subjects->count());
                return true;
            })
            ->set('search', 'Math')
            ->assertViewHas('subjects', function ($subjects) {
                // Vérifie que la recherche fonctionne
                $this->assertGreaterThan(0, $subjects->count());
                foreach ($subjects as $subject) {
                    $this->assertTrue(
                        str_contains(strtolower($subject->name), 'math')
                    );
                }
                return true;
            });
    }

    #[Test]
    public function it_can_create_new_subject()
    {
        Livewire::test(Subjects::class)
            ->call('create')
            ->assertSet('showModal', true)
            ->assertSet('editMode', false)
            ->set('name', 'Histoire-Géographie')
            ->set('code', 'HIST')
            ->set('description', 'Matière d\'histoire et géographie')
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que la matière a été créée en base
        $this->assertDatabaseHas('subjects', [
            'name' => 'Histoire-Géographie',
            'code' => 'HIST',
            'description' => 'Matière d\'histoire et géographie',
        ]);
    }

    #[Test]
    public function it_can_edit_existing_subject()
    {
        $subject = Subject::first();
        
        Livewire::test(Subjects::class)
            ->call('edit', $subject->id)
            ->assertSet('showModal', true)
            ->assertSet('editMode', true)
            ->assertSet('subjectId', $subject->id)
            ->assertSet('name', $subject->name)
            ->assertSet('code', $subject->code)
            ->assertSet('description', $subject->description)
            ->set('name', 'Mathématiques Avancées')
            ->set('code', 'MATH_ADV')
            ->set('description', 'Matière de mathématiques avancées')
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que la matière a été mise à jour
        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'name' => 'Mathématiques Avancées',
            'code' => 'MATH_ADV',
            'description' => 'Matière de mathématiques avancées',
        ]);
    }

    #[Test]
    public function it_validates_form_data_correctly()
    {
        Livewire::test(Subjects::class)
            ->call('create')
            ->set('name', 'AB') // Nom trop court (moins de 3 caractères)
            ->set('code', '') // Code vide
            ->set('description', '') // Description vide
            ->call('save')
            ->assertHasErrors([
                'name' => 'min',
                'code' => 'required',
                'description' => 'required'
            ])
            ->assertSet('showModal', true); // Le modal reste ouvert en cas d'erreur

        // Test avec nom vide
        Livewire::test(Subjects::class)
            ->call('create')
            ->set('name', '') // Nom vide
            ->set('code', 'TEST')
            ->set('description', 'Description test')
            ->call('save')
            ->assertHasErrors(['name' => 'required'])
            ->assertSet('showModal', true);

        // Vérifie qu'aucune matière n'a été créée
        $this->assertDatabaseMissing('subjects', [
            'name' => 'AB',
        ]);
        
        $this->assertDatabaseMissing('subjects', [
            'name' => '',
        ]);
    }
}