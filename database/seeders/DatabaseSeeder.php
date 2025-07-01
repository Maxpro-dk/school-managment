<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Créer 6 classes (une par spécialité)
        $classes = SchoolClass::factory(6)->create();

        // Créer 12 enseignants
        $teachers = Teacher::factory(12)->create();

        // Créer 14 matières
        $subjects = Subject::factory(14)->create();

        // Attribuer 2-3 matières à chaque enseignant
        foreach ($teachers as $teacher) {
            $teacher->subjects()->attach(
                $subjects->random(rand(2, 3))->pluck('id')->toArray()
            );
        }

        // Créer 30 étudiants par classe (180 au total)
        foreach ($classes as $class) {
            Student::factory(30)->create([
                'class_id' => $class->id
            ]);
        }

        // Créer 4 créneaux horaires par classe
        foreach ($classes as $class) {
            $classTeachers = $teachers->random(4);
            foreach ($classTeachers as $index => $teacher) {
                $subject = $teacher->subjects->random();
                Schedule::factory()->create([
                    'class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subject->id,
                ]);
            }
        }
    }
}
