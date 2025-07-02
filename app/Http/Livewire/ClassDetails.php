<?php

namespace App\Http\Livewire;

use App\Models\SchoolClass;
use App\Models\Schedule;
use Livewire\Component;
use Illuminate\Support\Collection;

class ClassDetails extends Component
{
    public $classId;
    public $schoolClass;
    public $students;
    public $weeklySchedule;
    public $classTeacher;
    public $totalStudents;
    public $subjectsCount;
    public $weekDays = [
        'lundi' => 'Lundi',
        'mardi' => 'Mardi', 
        'mercredi' => 'Mercredi',
        'jeudi' => 'Jeudi',
        'vendredi' => 'Vendredi',
        'samedi' => 'Samedi'
    ];

    public function mount($classId)
    {
        $this->classId = $classId;
        $this->loadClassData();
    }

    public function loadClassData()
    {
        // Charger les informations de la classe
        $this->schoolClass = SchoolClass::with(['teacher', 'students', 'schedules.subject', 'schedules.teacher'])
            ->findOrFail($this->classId);

        // Professeur principal de la classe
        $this->classTeacher = $this->schoolClass->teacher;

        // Étudiants de la classe
        $this->students = $this->schoolClass->students;
        $this->totalStudents = $this->students->count();

        // Programme hebdomadaire
        $this->weeklySchedule = $this->schoolClass->schedules
            ->groupBy('day')
            ->map(function ($daySchedules) {
                return $daySchedules->sortBy('start_time');
            });

        // Nombre de matières distinctes
        $this->subjectsCount = $this->schoolClass->schedules
            ->pluck('subject_id')
            ->unique()
            ->count();
    }

    public function render()
    {
        return view('livewire.class-details', [
            'schoolClass' => $this->schoolClass,
            'classTeacher' => $this->classTeacher,
            'students' => $this->students,
            'weeklySchedule' => $this->weeklySchedule,
            'totalStudents' => $this->totalStudents,
            'subjectsCount' => $this->subjectsCount,
            'weekDays' => $this->weekDays,
        ]);
    }
}