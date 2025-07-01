<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        // Noms de famille béninois courants
        $lastNames = [
            'Adjavon', 'Ahoyo', 'Akplogan', 'Assogba', 'Dagba',
            'Dossou', 'Gandaho', 'Houessou', 'Koudoro', 'Lokossou',
            'Mensah', 'Nobime', 'Quenum', 'Sossa', 'Togbe',
            'Yayi', 'Zinsou', 'Zodjihoue'
        ];

        // Prénoms béninois courants
        $firstNames = [
            'Abiba', 'Abiola', 'Adebayo', 'Adeline', 'Adjoa',
            'Akuavi', 'Alade', 'Ayodele', 'Boni', 'Cossi',
            'Dossa', 'Fifamè', 'Folami', 'Koffi', 'Kokou',
            'Mensah', 'Olayinka', 'Séwade', 'Yaovi'
        ];

        $registrationYear = '2023';
        static $registrationNumber = 1;

        return [
            'first_name' => $this->faker->randomElement($firstNames),
            'last_name' => $this->faker->randomElement($lastNames),
            'birth_date' => $this->faker->dateTimeBetween('-25 years', '-18 years'),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'registration_number' => $registrationYear . str_pad($registrationNumber++, 4, '0', STR_PAD_LEFT),
            'class_id' => SchoolClass::factory(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '+229 ' . $this->faker->numberBetween(40000000, 99999999),
            'address' => $this->faker->randomElement([
                'Cotonou, Akpakpa',
                'Porto-Novo, Djassin',
                'Abomey-Calavi, Tokan',
                'Parakou, Albarika',
                'Bohicon, Zakpo'
            ]),
        ];
    }
} 