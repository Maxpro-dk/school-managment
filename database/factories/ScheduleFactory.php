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
            ['07:30', '10:30'],
            ['10:45', '13:45'],
            ['14:30', '17:30']
        ];

        $rooms = [
            'Amphi A', 'Amphi B', 'Amphi C',
            'Salle 101', 'Salle 102', 'Salle 103',
            'Labo Info 1', 'Labo Info 2',
            'Salle TP Physique', 'Salle TP Chimie'
        ];

        $timeSlot = $this->faker->randomElement($timeSlots);

        return [
            'class_id' => SchoolClass::factory(),
            'subject_id' => Subject::factory(),
            'teacher_id' => Teacher::factory(),
            'day' => $this->faker->randomElement(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi']),
            'start_time' => $timeSlot[0],
            'end_time' => $timeSlot[1],
            'room' => $this->faker->randomElement($rooms),
            'coefficient' => $this->faker->randomElement([1, 2, 3, 4]),
        ];
    }
} 