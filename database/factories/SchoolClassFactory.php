<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    protected $model = SchoolClass::class;

    public function definition()
    {
        $levels = ['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'];
        $level = $this->faker->randomElement($levels);
        
        return [
            'name' => $level . ' ' . $this->faker->randomLetter(),
            'level' => $level,
            'academic_year' => '2023-2024',
        ];
    }
} 