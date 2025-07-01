<?php

namespace App\Http\Livewire;

use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolClasses extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $classId;
    public $name;
    public $level;
    public $academic_year;

    protected $rules = [
        'name' => 'required|min:3',
        'level' => 'required',
        'academic_year' => 'required|regex:/^\d{4}-\d{4}$/',
    ];

    protected $messages = [
        'name.required' => 'Le nom de la classe est requis',
        'name.min' => 'Le nom doit contenir au moins 3 caractères',
        'level.required' => 'Le niveau est requis',
        'academic_year.required' => 'L\'année académique est requise',
        'academic_year.regex' => 'L\'année académique doit être au format YYYY-YYYY',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $classes = SchoolClass::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('level', 'like', '%' . $this->search . '%')
            ->orWhere('academic_year', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.school-classes', [
            'classes' => $classes
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['name', 'level', 'academic_year']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->editMode = true;
        $this->classId = $id;
        $class = SchoolClass::find($id);
        $this->name = $class->name;
        $this->level = $class->level;
        $this->academic_year = $class->academic_year;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $class = SchoolClass::find($this->classId);
            $class->update([
                'name' => $this->name,
                'level' => $this->level,
                'academic_year' => $this->academic_year,
            ]);
        flash()->success('Classe mise à jour avec succès.');
        } else {
            SchoolClass::create([
                'name' => $this->name,
                'level' => $this->level,
                'academic_year' => $this->academic_year,
            ]);
        flash()->success('Classe créée avec succès.');
        }

        $this->showModal = false;
        $this->reset(['name', 'level', 'academic_year']);
    }

    public function delete($id)
    {
        $class = SchoolClass::find($id);
        if ($class->students()->count() > 0) {
        flash()->error('Impossible de supprimer cette classe car elle contient des étudiants.');
            return;
        }
        $class->delete();
        flash()->success('Classe supprimée avec succès.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['name', 'level', 'academic_year']);
    }
} 