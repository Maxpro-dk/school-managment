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
    public $gender;
    public $registration_number;
    public $tutor_name;
    public $tutor_phone;
    public $tutor_email;
    public $address;
    public $birth_date;
    public $school_class_id;

    public $currentClassId;

    public $perPage = 10;

    

    public function mount($currentClassId = null)
    {
        
      $this->currentClassId = $currentClassId;
        if ($this->currentClassId) {
            $this->school_class_id = $this->currentClassId;
            $this->perPage = 5; // Show all students in the current class
        }
    }


    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'tutor_name' => 'required|string',
        'tutor_phone' => 'required|string',
        'tutor_email' => 'required|email',
        'address' => 'required|string',
        'birth_date' => 'required|date',
        'school_class_id' => 'required|exists:school_classes,id',
        'gender' => 'required|string',
        'registration_number' => 'required|string|unique:students,registration_number',
    ];

    protected $messages = [
        'first_name.required' => 'Le prénom est requis',
        'first_name.min' => 'Le prénom doit contenir au moins 2 caractères',
        'last_name.required' => 'Le nom est requis',
        'last_name.min' => 'Le nom doit contenir au moins 2 caractères',
        'tutor_email.required' => 'L\'email est requis',
        'tutor_email.email' => 'L\'email doit être une adresse email valide',
        'tutor_phone.required' => 'Le téléphone est requis',
        'address.required' => 'L\'adresse est requise',
        'birth_date.required' => 'La date de naissance est requise',
        'birth_date.date' => 'La date de naissance doit être une date valide',
        'school_class_id.required' => 'La classe est requise',
        'school_class_id.exists' => 'La classe sélectionnée n\'existe pas',
        'gender.required' => 'Le genre est requis',
        'registration_number.required' => 'Le numéro d\'inscription est requis',
        'registration_number.unique' => 'Le numéro d\'inscription doit être unique',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::query();
        if ($this->currentClassId) {
            $students = $students->where('school_class_id', '=', $this->currentClassId);
        }
        $students  =   $students->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('tutor_email', 'like', '%' . $this->search . '%')
                    ->orWhere('tutor_phone', 'like', '%' . $this->search . '%');
            })
            ->orderBy('last_name', 'desc')
            ->paginate($this->perPage);

        $classes = SchoolClass::all();

        return view('livewire.students', [
            'students' => $students,
            'classes' => $classes
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['first_name', 'last_name', 'tutor_email', 'tutor_phone', 'tutor_name', 'gender', 'address', 'birth_date', 'school_class_id', 'registration_number']);
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
        $this->tutor_email = $student->tutor_email;
        $this->tutor_phone = $student->tutor_phone;
        $this->tutor_name = $student->tutor_name;
        $this->gender = $student->gender;
        $this->address = $student->address;
        $this->birth_date = $student->birth_date;
        $this->school_class_id = $student->school_class_id;
        $this->registration_number = $student->registration_number;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $student = Student::find($this->studentId);
            $student->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'tutor_email' => $this->tutor_email,
                'tutor_phone' => $this->tutor_phone,
                'tutor_name' => $this->tutor_name,
                'gender' => $this->gender,
                'address' => $this->address,
                'birth_date' => $this->birth_date,
                'school_class_id' => $this->school_class_id,
                'registration_number' => $this->registration_number,
            ]);
            flash()->success('Étudiant mis à jour avec succès.');
        } else {
            Student::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'tutor_email' => $this->tutor_email,
                'tutor_phone' => $this->tutor_phone,
                'tutor_name' => $this->tutor_name,
                'gender' => $this->gender,
                'address' => $this->address,
                'birth_date' => $this->birth_date,
                'school_class_id' => $this->school_class_id,
                'registration_number' => $this->registration_number,
            ]);
            flash()->success('Étudiant créé avec succès.');
        }

        $this->showModal = false;
        $this->reset(['first_name', 'last_name', 'tutor_email', 'tutor_phone', 'tutor_name', 'gender', 'address', 'birth_date', 'school_class_id', 'registration_number']);
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
        $this->reset(['first_name', 'last_name', 'tutor_email', 'tutor_phone', 'tutor_name', 'gender', 'address', 'birth_date', 'school_class_id', 'registration_number']);
    }
}
