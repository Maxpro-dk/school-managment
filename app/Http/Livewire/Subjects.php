<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subject;
use Livewire\WithPagination;

class Subjects extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $subjectId;
    public $name;
    public $description;
    public $code;

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'required',
        'code' => 'required|string',
    ];

    protected $messages = [
        'name.required' => 'Le nom de la matière est requis',
        'name.min' => 'Le nom doit contenir au moins 3 caractères',
        'description.required' => 'La description est requise',
        'code.required' => 'Le code est requis',
        'code.string' => 'Le code doit être un nombre',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $subjects = Subject::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.subjects', [
            'subjects' => $subjects
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['name', 'description', 'code']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->editMode = true;
        $this->subjectId = $id;
        $subject = Subject::find($id);
        $this->name = $subject->name;
        $this->description = $subject->description;
        $this->code = $subject->code;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $subject = Subject::find($this->subjectId);
            $subject->update([
                'name' => $this->name,
                'description' => $this->description,
                'code' => $this->code,
            ]);
            flash()->success('Matière mise à jour avec succès.');
        } else {
            Subject::create([
                'name' => $this->name,
                'description' => $this->description,
                'code' => $this->code,
            ]);
            flash()->success('Matière créée avec succès.');
        }

        $this->showModal = false;
        $this->reset(['name', 'description', 'code']);
    }

    public function delete($id)
    {
        $subject = Subject::find($id);
        if ($subject->teachers()->count() > 0) {
            flash()->error('Impossible de supprimer cette matière car elle est assignée à des enseignants.');
            return;
        }
        $subject->delete();
        flash()->success('Matière supprimée avec succès.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['name', 'description', 'code']);
    }
} 