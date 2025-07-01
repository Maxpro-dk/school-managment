<?php

namespace App\Http\Livewire;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Schedule;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalStudents;
    public $totalTeachers;
    public $totalClasses;
    public $totalSubjects;
    public $classesWithMostStudents;
    public $teachersWithMostSubjects;
    public $upcomingSchedules;
    public $studentsPerClass;

    public function mount()
    {
        $this->totalStudents = Student::count();
        $this->totalTeachers = Teacher::count();
        $this->totalClasses = SchoolClass::count();
        $this->totalSubjects = Subject::count();

        // Classes avec le plus d'étudiants
        $this->classesWithMostStudents = SchoolClass::withCount('students')
            ->orderByDesc('students_count')
            ->take(5)
            ->get();

        // Professeurs avec le plus de matières
        $this->teachersWithMostSubjects = Teacher::withCount('subjects')
            ->orderByDesc('subjects_count')
            ->take(5)
            ->get();

        // Emplois du temps à venir (aujourd'hui)
        $this->upcomingSchedules = Schedule::with(['class', 'subject', 'teacher'])
            ->where('day', strtolower(now()->locale('fr')->dayName))
            ->where('start_time', '>=', now()->format('H:i:s'))
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Répartition des étudiants par classe
        $this->studentsPerClass = Student::select('class_id', DB::raw('count(*) as count'))
            ->groupBy('class_id')
            ->with('schoolClass')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->class?->name,
                    'count' => $item->count,
                ];
            });
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
