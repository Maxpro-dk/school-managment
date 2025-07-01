<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        $subjects = [
            'Analyse Mathématique' => 'MAT',
            'Algèbre Linéaire' => 'ALG',
            'Programmation' => 'INF',
            'Base de Données' => 'BDD',
            'Droit Civil' => 'DCL',
            'Droit Commercial' => 'DCM',
            'Microéconomie' => 'MIC',
            'Macroéconomie' => 'MAC',
            'Comptabilité Générale' => 'CPT',
            'Marketing' => 'MKT',
            'Résistance des Matériaux' => 'RDM',
            'Mécanique des Fluides' => 'MFL',
            'Production Végétale' => 'PVG',
            'Production Animale' => 'PAN'
        ];

        $subjectName = $this->faker->unique()->randomElement(array_keys($subjects));
        $code = $subjects[$subjectName];
        
        return [
            'name' => $subjectName,
            'code' => $code . $this->faker->numberBetween(100, 999),
            'coefficient' => $this->faker->randomElement([1, 2, 3, 4, 5]),
        ];
    }
} 