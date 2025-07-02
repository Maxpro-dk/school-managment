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

        // Calculer l'âge en fonction du niveau de la classe
        $class = SchoolClass::find($this->faker->randomElement(SchoolClass::pluck('id')));
        $ageRange = $this->getAgeRangeForLevel($class ? $class->level : 'CI');

        return [
            'first_name' => $this->faker->randomElement($firstNames),
            'last_name' => $this->faker->randomElement($lastNames),
            'birth_date' => $this->faker->dateTimeBetween("-{$ageRange['max']} years", "-{$ageRange['min']} years"),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'registration_number' => $registrationYear . str_pad($registrationNumber++, 4, '0', STR_PAD_LEFT),
            'school_class_id' => $class ? $class->id : SchoolClass::factory(),
            'email' => null, // Les élèves du primaire n'ont pas d'email
            'phone' => null, // Les élèves du primaire n'ont pas de téléphone
            'address' => $this->faker->randomElement([
                'Cotonou, Akpakpa',
                'Porto-Novo, Djassin',
                'Abomey-Calavi, Tokan',
                'Parakou, Albarika',
                'Bohicon, Zakpo'
            ]),
        ];
    }

    private function getAgeRangeForLevel($level)
    {
        $ageRanges = [
            'CI' => ['min' => 5, 'max' => 6],
            'CP' => ['min' => 6, 'max' => 7],
            'CE1' => ['min' => 7, 'max' => 8],
            'CE2' => ['min' => 8, 'max' => 9],
            'CM1' => ['min' => 9, 'max' => 10],
            'CM2' => ['min' => 10, 'max' => 11],
        ];

        return $ageRanges[$level] ?? ['min' => 5, 'max' => 6];
    }
} 