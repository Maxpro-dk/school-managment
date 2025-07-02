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
            'Français' => [
                'code' => 'FRA',
                'description' => 'Lecture, écriture, grammaire, conjugaison et expression orale'
            ],
            'Mathématiques' => [
                'code' => 'MAT',
                'description' => 'Calcul, géométrie et résolution de problèmes'
            ],
            'Education Civique et Morale' => [
                'code' => 'ECM',
                'description' => 'Citoyenneté, morale et valeurs sociales'
            ],
            'Histoire-Géographie' => [
                'code' => 'HGE',
                'description' => 'Histoire et géographie du Bénin et du monde'
            ],
            'Sciences de la Vie et de la Terre' => [
                'code' => 'SVT',
                'description' => 'Sciences naturelles, environnement et santé'
            ],
            'Education Physique et Sportive' => [
                'code' => 'EPS',
                'description' => 'Sport, jeux et développement physique'
            ],
            'Activités Pratiques et Productives' => [
                'code' => 'APP',
                'description' => 'Travaux manuels et activités pratiques'
            ]
        ];

        $subjectName = $this->faker->unique()->randomElement(array_keys($subjects));
        $subject = $subjects[$subjectName];
        
        return [
            'name' => $subjectName,
            'code' => $subject['code'],
            'description' => $subject['description'],
        ];
    }
} 