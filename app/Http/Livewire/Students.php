<?php

namespace App\Http\Livewire;

use App\Models\Student;
use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $studentId;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $birth_date;
    public $school_class_id;

    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'email' => 'required|email|unique:students,email',
        'phone' => 'required|string',
        'address' => 'required|string',
        'birth_date' => 'required|date',
        'school_class_id' => 'required|exists:school_classes,id',
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
        'birth_date.required' => 'La date de naissance est requise',
        'birth_date.date' => 'La date de naissance doit être une date valide',
        'school_class_id.required' => 'La classe est requise',
        'school_class_id.exists' => 'La classe sélectionnée n\'existe pas',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::where('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $classes = SchoolClass::all();

        return view('livewire.students', [
            'students' => $students,
            'classes' => $classes
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'birth_date', 'school_class_id']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->editMode = true;
        $this->studentId = $id;
        $student = Student::find($id);
        $this->first_name = $student->first_name;
        $this->last_name = $student->last_name;
        $this->email = $student->email;
        $this->phone = $student->phone;
        $this->address = $student->address;
        $this->birth_date = $student->birth_date;
        $this->school_class_id = $student->school_class_id;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->rules['email'] = 'required|email|unique:students,email,' . $this->studentId;
        }

        $this->validate();

        if ($this->editMode) {
            $student = Student::find($this->studentId);
            $student->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'birth_date' => $this->birth_date,
                'school_class_id' => $this->school_class_id,
            ]);
            flash()->success('Étudiant mis à jour avec succès.');
        } else {
            Student::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'birth_date' => $this->birth_date,
                'school_class_id' => $this->school_class_id,
            ]);
            flash()->success('Étudiant créé avec succès.');
        }

        $this->showModal = false;
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'birth_date', 'school_class_id']);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
        flash()->success('Étudiant supprimé avec succès.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'birth_date', 'school_class_id']);
    }
} 