<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition()
    {
        $timeSlots = [
            ['08:00', '09:30'], // Première séance du matin
            ['10:00', '11:30'], // Deuxième séance du matin
            ['15:00', '16:30']  // Séance de l'après-midi
        ];

        $timeSlot = $this->faker->randomElement($timeSlots);
        $class = SchoolClass::inRandomOrder()->first() ?? SchoolClass::factory()->create();

        return [
            'class_id' => $class->id,
            'subject_id' => Subject::inRandomOrder()->first()->id ?? Subject::factory()->create()->id,
            'teacher_id' => $class->teacher_id ?? Teacher::factory()->create()->id,
            'day' => $this->faker->randomElement(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']),
            'start_time' => $timeSlot[0],
            'end_time' => $timeSlot[1],
            'room' => 'Salle ' . $class->name,
            'coefficient' => $this->faker->randomElement([1, 2]), // Coefficients plus simples pour le primaire
        ];
    }
} 