<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition()
    {
        // Noms de famille béninois courants
        $lastNames = [
            'Adjavon', 'Ahoyo', 'Akplogan', 'Assogba', 'Dagba',
            'Dossou', 'Gandaho', 'Houessou', 'Koudoro', 'Lokossou',
            'Mensah', 'Nobime', 'Quenum', 'Sossa', 'Togbe'
        ];

        // Prénoms béninois courants
        $firstNames = [
            'Abiba', 'Abiola', 'Adebayo', 'Adeline', 'Adjoa',
            'Akuavi', 'Alade', 'Ayodele', 'Boni', 'Cossi',
            'Dossa', 'Fifamè', 'Folami', 'Koffi', 'Kokou'
        ];

        $titles = ['Dr.', 'Prof.', 'MC'];
        $specialties = [
            'Mathématiques et Informatique',
            'Sciences Physiques',
            'Génie Civil',
            'Sciences Économiques',
            'Droit Public',
            'Droit Privé',
            'Agronomie',
            'Génie Mécanique',
            'Sciences de Gestion',
            'Sociologie'
        ];

        $firstName = $this->faker->unique()->randomElement($firstNames);
        $lastName = $this->faker->unique()->randomElement($lastNames);
        $title = $this->faker->randomElement($titles);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName . '.' . $lastName . '.' . $this->faker->unique()->numberBetween(1, 999) . '@univ-benin.bj'),
            'phone' => '+229 ' . $this->faker->numberBetween(40000000, 99999999),
            'specialty' => $title . ' en ' . $this->faker->randomElement($specialties),
        ];
    }
} 