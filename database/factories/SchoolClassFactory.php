<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    protected $model = SchoolClass::class;

    public function definition()
    {
        $levels = [
            'Licence 1', 'Licence 2', 'Licence 3',
            'Master 1', 'Master 2'
        ];

        $specialties = [
            'Informatique',
            'Génie Civil',
            'Gestion',
            'Agronomie',
            'Sciences Économiques',
            'Droit'
        ];

        return [
            'name' => $this->faker->randomElement($levels) . ' ' . $this->faker->randomElement($specialties),
            'level' => $this->faker->randomElement($levels),
            'academic_year' => '2023-2024',
        ];
    }
} 