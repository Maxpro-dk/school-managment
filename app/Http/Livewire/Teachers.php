<?php

namespace App\Http\Livewire;

use App\Models\Teacher;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Teachers extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $teacherId;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $specialty;
    public $subjects = [];
    public $selectedSubjects = [];

    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'email' => 'required|email|unique:teachers,email',
        'phone' => 'required|string',
        'address' => 'required|string',
        'specialty' => 'required|string',
        'selectedSubjects' => 'required|array|min:1',
    ];

    protected $messages = [
        'first_name.required' => 'Le prénom est requis',
        'first_name.min' => 'Le prénom doit contenir au moins 2 caractères',
        'last_name.required' => 'Le nom est requis',
        'last_name.min' => 'Le nom doit contenir au moins 2 caractères',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être une adresse email valide',
        'email.unique' => 'Cette adresse email est déjà utilisée',
        'phone.required' => 'Le téléphone est requis',
        'address.required' => 'L\'adresse est requise',
        'specialty.required' => 'La spécialité est requise',
        'selectedSubjects.required' => 'Veuillez sélectionner au moins une matière',
        'selectedSubjects.min' => 'Veuillez sélectionner au moins une matière',
    ];

    public function mount()
    {
        $this->subjects = Subject::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $teachers = Teacher::where('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.teachers', [
            'teachers' => $teachers
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'specialty', 'selectedSubjects']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->editMode = true;
        $this->teacherId = $id;
        $teacher = Teacher::find($id);
        $this->first_name = $teacher->first_name;
        $this->last_name = $teacher->last_name;
        $this->email = $teacher->email;
        $this->phone = $teacher->phone;
        $this->address = $teacher->address;
        $this->specialty = $teacher->specialty;
        $this->selectedSubjects = $teacher->subjects->pluck('id')->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->rules['email'] = 'required|email|unique:teachers,email,' . $this->teacherId;
        }

        $this->validate();

        if ($this->editMode) {
            $teacher = Teacher::find($this->teacherId);
            $teacher->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'specialty' => $this->specialty,
            ]);
            $teacher->subjects()->sync($this->selectedSubjects);
            flash()->success('Professeur mis à jour avec succès.');
        } else {
            $teacher = Teacher::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'specialty' => $this->specialty,
            ]);
            $teacher->subjects()->attach($this->selectedSubjects);
            flash()->success('Professeur créé avec succès.');
        }

        $this->showModal = false;
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'specialty', 'selectedSubjects']);
    }

    public function delete($id)
    {
        $teacher = Teacher::find($id);
        $teacher->subjects()->detach();
        $teacher->delete();
        flash()->success('Professeur supprimé avec succès.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'specialty', 'selectedSubjects']);
    }
} 