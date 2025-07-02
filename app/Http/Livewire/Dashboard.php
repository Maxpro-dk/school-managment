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
    
        // Emplois du temps à venir (aujourd'hui)
        $this->upcomingSchedules = Schedule::with(['schoolClass', 'subject', 'teacher'])
            ->where('day', strtolower(now()->locale('fr')->dayName))
            ->where('start_time', '>=', now()->format('H:i:s'))
            ->orderBy('start_time')
            ->take(5)
            ->get();
   
    }

    public function render()
    {
        // Répartition des étudiants par classe
        $studentsPerClass = SchoolClass::select(
            'school_classes.id',
            'school_classes.name',
            'school_classes.level',
            'school_classes.teacher_id',
            DB::raw('(SELECT COUNT(*) FROM students WHERE students.school_class_id = school_classes.id) as student_count')
        )
        ->with(['teacher:id,first_name,last_name']) // Eager loading de l'enseignant
        ->get()
        ->groupBy('level');


           
        
        return view('livewire.dashboard', [
            'totalStudents' => $this->totalStudents,
            'totalTeachers' => $this->totalTeachers,
            'totalClasses' => $this->totalClasses,
            'totalSubjects' => $this->totalSubjects,
            'studentsPerClass' => $studentsPerClass
        ]);
    }
}
