<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition()
    {
        $diplomas = [
            'CAP', // Certificat d'Aptitude Pédagogique
            'CEAP', // Certificat Élémentaire d'Aptitude Pédagogique
            'BEPD', // Brevet d'Études Pédagogiques du Degré
            'Licence en Sciences de l\'Education'
        ];

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'diploma' => $this->faker->randomElement($diplomas),
            'address' => $this->faker->address(),
            'birth_date' => $this->faker->dateTimeBetween('-50 years', '-25 years')->format('Y-m-d'),
        ];
    }
}
