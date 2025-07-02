<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Students;
use App\Models\Student;
use App\Models\SchoolClass;
use Database\Seeders\BeninSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Exécuter le seeder pour avoir des données de test
        $this->seed(BeninSchoolSeeder::class);
    }

    #[Test]
    public function it_displays_students_and_handles_search()
    {
        Livewire::test(Students::class)
            ->assertViewHas('students', function ($students) {
                // Vérifie qu'il y a des étudiants (le seeder crée entre 25-35 étudiants par classe)
                $this->assertGreaterThan(0, $students->count());
                return true;
            })
            ->set('search', 'Abiola') // Recherche un prénom du seeder
            ->assertViewHas('students', function ($students) {
                // Vérifie que la recherche fonctionne
                if ($students->count() > 0) {
                    foreach ($students as $student) {
                        $this->assertTrue(
                            str_contains($student->first_name, 'Abiola') || 
                            str_contains($student->last_name, 'Abiola') ||
                            str_contains($student->tutor_email, 'Abiola') ||
                            str_contains($student->tutor_phone, 'Abiola')
                        );
                    }
                }
                return true;
            });
    }

    #[Test]
    public function it_can_create_new_student()
    {
        $class = SchoolClass::first();
        
        Livewire::test(Students::class)
            ->call('create')
            ->assertSet('showModal', true)
            ->assertSet('editMode', false)
            ->set('first_name', 'Nouveau')
            ->set('last_name', 'Etudiant')
            ->set('gender', 'M')
            ->set('registration_number', '2024TEST001')
            ->set('tutor_name', 'Tuteur Test')
            ->set('tutor_phone', '+229 12 34 56 78')
            ->set('tutor_email', 'tuteur@test.com')
            ->set('address', 'Adresse de test')
            ->set('birth_date', '2015-01-01')
            ->set('school_class_id', $class->id)
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que l'étudiant a été créé en base
        $this->assertDatabaseHas('students', [
            'first_name' => 'Nouveau',
            'last_name' => 'Etudiant',
            'registration_number' => '2024TEST001',
            'school_class_id' => $class->id,
        ]);
    }

    #[Test]
    public function it_can_edit_existing_student()
    {
        $student = Student::first();
        $newClass = SchoolClass::where('id', '!=', $student->school_class_id)->first();
        
        Livewire::test(Students::class)
            ->call('edit', $student->id)
            ->assertSet('showModal', true)
            ->assertSet('editMode', true)
            ->assertSet('studentId', $student->id)
            ->assertSet('first_name', $student->first_name)
            ->assertSet('last_name', $student->last_name)
            ->set('first_name', 'Prénom Modifié')
            ->set('last_name', 'Etudiant')
            ->set('gender', 'M')
            ->set('registration_number', '2024TEST001')
            ->set('tutor_name', 'Tuteur Test')
            ->set('tutor_phone', '+229 12 34 56 78')
            ->set('tutor_email', 'tuteur@test.com')
            ->set('address', 'Adresse de test')
            ->set('birth_date', '2015-01-01')
            ->set('school_class_id', $newClass->id)
            ->call('save')
            ->assertSet('showModal', false);

        // Vérifie que l'étudiant a été mis à jour
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'first_name' => 'Prénom Modifié',
            'school_class_id' => $newClass->id,
        ]);
    }

    #[Test]
    public function it_validates_form_data_correctly()
    {
        Livewire::test(Students::class)
            ->call('create')
            ->set('first_name', 'A') // Trop court
            ->set('last_name', '') // Vide
            ->set('tutor_email', 'email-invalide') // Email invalide
            ->set('tutor_phone', '') // Vide
            ->set('tutor_name', '') // Vide
            ->set('gender', '') // Vide
            ->set('address', '') // Vide
            ->set('birth_date', 'date-invalide') // Date invalide
            ->set('school_class_id', 9999) // Classe inexistante
            ->set('registration_number', '') // Vide
            ->call('save')
            ->assertHasErrors([
                'first_name' => 'min',
                'last_name' => 'required',
                'tutor_email' => 'email',
                'tutor_phone' => 'required',
                'tutor_name' => 'required',
                'gender' => 'required',
                'address' => 'required',
                'birth_date' => 'date',
                'school_class_id' => 'exists',
                'registration_number' => 'required'
            ])
            ->assertSet('showModal', true); // Le modal reste ouvert en cas d'erreur

        // Teste aussi l'unicité du numéro d'inscription
        $existingStudent = Student::first();
        
        Livewire::test(Students::class)
            ->call('create')
            ->set('first_name', 'Test')
            ->set('last_name', 'Student')
            ->set('tutor_email', 'test@example.com')
            ->set('tutor_phone', '+229 12 34 56 78')
            ->set('tutor_name', 'Test Tutor')
            ->set('gender', 'M')
            ->set('address', 'Test Address')
            ->set('birth_date', '2015-01-01')
            ->set('school_class_id', SchoolClass::first()->id)
            ->set('registration_number', $existingStudent->registration_number) // Numéro déjà existant
            ->call('save')
            ->assertHasErrors(['registration_number' => 'unique']);
    }
}