<?php

namespace App\Http\Livewire;

use App\Models\Teacher;
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
    public $diploma;
    public $birth_date;

    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'email' => 'required|email|unique:teachers,email',
        'phone' => 'required|string',
        'address' => 'required|string',
        'diploma' => 'required|string',
        'birth_date' => 'required|date',
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
        'diploma.required' => 'Le diplôme est requis',
        'birth_date.required' => 'La date de naissance est requise',
        'birth_date.date' => 'La date de naissance doit être une date valide',
    ];

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
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'diploma', 'birth_date']);
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
        $this->diploma = $teacher->diploma;
        $this->birth_date = $teacher->birth_date;
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
                'diploma' => $this->diploma,
                'birth_date' => $this->birth_date,
            ]);
            flash()->success('Professeur mis à jour avec succès.');
        } else {
            Teacher::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'diploma' => $this->diploma,
                'birth_date' => $this->birth_date,
            ]);
            flash()->success('Professeur créé avec succès.');
        }

        $this->showModal = false;
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'diploma', 'birth_date']);
    }

    public function delete($id)
    {
        $teacher = Teacher::find($id);
        $teacher->delete();
        flash()->success('Professeur supprimé avec succès.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'address', 'diploma', 'birth_date']);
    }
}
