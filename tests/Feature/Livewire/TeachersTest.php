<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Teachers;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TeachersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer quelques enseignants de test
        Teacher::factory()->create([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'phone' => '0123456789',
            'address' => '123 Rue de la Paix',
            'diploma' => 'Master en Mathématiques',
            'birth_date' => '1980-05-15'
        ]);
        
        Teacher::factory()->create([
            'first_name' => 'Marie',
            'last_name' => 'Martin',
            'email' => 'marie.martin@example.com',
            'phone' => '0987654321',
            'address' => '456 Avenue des Écoles',
            'diploma' => 'Licence en Français',
            'birth_date' => '1985-08-22'
        ]);
        
        Teacher::factory()->create([
            'first_name' => 'Pierre',
            'last_name' => 'Durand',
            'email' => 'pierre.durand@example.com',
            'phone' => '0147258369',
            'address' => '789 Boulevard de l\'Éducation',
            'diploma' => 'Master en Sciences',
            'birth_date' => '1978-12-03'
        ]);
    }

    #[Test]
    public function it_displays_teachers_and_handles_search()
    {
        Livewire::test(Teachers::class)
            ->assertViewHas('teachers', function ($teachers) {
                // Vérifie qu'il y a des enseignants
                $this->assertGreaterThan(0, $teachers->count());
                return true;
            })
            ->set('search', 'Jean')
            ->assertViewHas('teachers', function ($teachers) {
                // Vérifie que la recherche fonctionne (par prénom)
                $this->assertGreaterThan(0, $teachers->count());
                foreach ($teachers as $teacher) {
                    $this->assertTrue(
                        str_contains(strtolower($teacher->first_name), 'jean') ||
                        str_contains(strtolower($teacher->last_name), 'jean') ||
                        str_contains(strtolower($teacher->email), 'jean')
                    );
                }
                return true;
            })
            ->set('search', 'martin@example.com')
            ->assertViewHas('teachers', function ($teachers) {
                // Vérifie que la recherche fonctionne aussi par email
                $this->assertGreaterThan(0, $teachers->count());
                foreach ($teachers as $teacher) {
                    $this->assertTrue(
                        str_contains(strtolower($teacher->first_name), 'martin') ||
                        str_contains(strtolower($teacher->last_name), 'martin') ||
                        str_contains(strtolower($teacher->email), 'martin')
                    );
                }
                return true;
            });
    }

    #[Test]
    public function it_can_create_new_teacher()
    {
        Livewire::test(Teachers::class)
            ->call('create')
            ->assertSet('showModal', true)
            ->assertSet('editMode', false)
            ->set('first_name', 'Sophie')
            ->set('last_name', 'Bernard')
            ->set('email', 'sophie.bernard@example.com')
            ->set('phone', '0156789012')
            ->set('address', '321 Rue de l\'École')
            ->set('diploma', 'Master en Histoire')
            ->set('birth_date', '1982-03-10')
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que l'enseignant a été créé en base
        $this->assertDatabaseHas('teachers', [
            'first_name' => 'Sophie',
            'last_name' => 'Bernard',
            'email' => 'sophie.bernard@example.com',
            'phone' => '0156789012',
            'address' => '321 Rue de l\'École',
            'diploma' => 'Master en Histoire',
            'birth_date' => '1982-03-10',
        ]);
    }

    #[Test]
    public function it_can_edit_existing_teacher()
    {
        $teacher = Teacher::first();
        
        Livewire::test(Teachers::class)
            ->call('edit', $teacher->id)
            ->assertSet('showModal', true)
            ->assertSet('editMode', true)
            ->assertSet('teacherId', $teacher->id)
            ->assertSet('first_name', $teacher->first_name)
            ->assertSet('last_name', $teacher->last_name)
            ->assertSet('email', $teacher->email)
            ->set('first_name', 'Jean-Claude')
            ->set('diploma', 'Doctorat en Mathématiques')
            ->set('address', '999 Nouvelle Adresse')
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que l'enseignant a été mis à jour
        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'first_name' => 'Jean-Claude',
            'diploma' => 'Doctorat en Mathématiques',
            'address' => '999 Nouvelle Adresse',
            'email' => $teacher->email, // L'email reste le même
        ]);
    }

    #[Test]
    public function it_validates_form_data_correctly()
    {
        Livewire::test(Teachers::class)
            ->call('create')
            ->set('first_name', 'A') // Prénom trop court
            ->set('last_name', '') // Nom vide
            ->set('email', 'email-invalide') // Email invalide
            ->set('phone', '') // Téléphone vide
            ->set('address', '') // Adresse vide
            ->set('diploma', '') // Diplôme vide
            ->set('birth_date', 'date-invalide') // Date invalide
            ->call('save')
            ->assertHasErrors([
                'first_name' => 'min',
                'last_name' => 'required',
                'email' => 'email',
                'phone' => 'required',
                'address' => 'required',
                'diploma' => 'required',
                'birth_date' => 'date'
            ])
            ->assertSet('showModal', true); // Le modal reste ouvert en cas d'erreur

        // Test de l'unicité de l'email
        $existingTeacher = Teacher::first();
        
        Livewire::test(Teachers::class)
            ->call('create')
            ->set('first_name', 'Nouveau')
            ->set('last_name', 'Professeur')
            ->set('email', $existingTeacher->email) // Email déjà utilisé
            ->set('phone', '0123456789')
            ->set('address', 'Une adresse')
            ->set('diploma', 'Un diplôme')
            ->set('birth_date', '1990-01-01')
            ->call('save')
            ->assertHasErrors(['email' => 'unique'])
            ->assertSet('showModal', true);

        // Vérifie qu'aucun enseignant n'a été créé avec des données invalides
        $this->assertDatabaseMissing('teachers', [
            'first_name' => 'A',
        ]);
        
        $this->assertDatabaseMissing('teachers', [
            'first_name' => 'Nouveau',
            'last_name' => 'Professeur',
        ]);
    }
}