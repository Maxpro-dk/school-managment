<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $userId;

    // Form fields
    public $name;
    public $email;
    public $password;
    public $phone;
    public $location;
    public $about;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'phone' => 'nullable|string|max:20',
        'location' => 'nullable|string|max:100',
        'about' => 'nullable|string',
    ];

    protected $messages = [
        'name.required' => 'Le nom est requis',
        'name.min' => 'Le nom doit contenir au moins 3 caractères',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être une adresse email valide',
        'email.unique' => 'Cette adresse email est déjà utilisée',
        'password.required' => 'Le mot de passe est requis',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères',
        'location.max' => 'La localisation ne doit pas dépasser 100 caractères',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user-management', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'phone', 'location', 'about']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->editMode = true;
        $this->userId = $id;
        
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->location = $user->location;
        $this->about = $user->about;
        
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->rules['email'] = 'required|email|unique:users,email,' . $this->userId;
            $this->rules['password'] = 'nullable|min:6';
        }

        $this->validate();

        if ($this->editMode) {
            $user = User::find($this->userId);
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'location' => $this->location,
                'about' => $this->about,
            ];

            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }

            $user->update($userData);
            flash()->success('Utilisateur mis à jour avec succès.');
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
                'location' => $this->location,
                'about' => $this->about,
            ]);
            flash()->success('Utilisateur créé avec succès.');
        }

        $this->showModal = false;
        $this->reset(['name', 'email', 'password', 'phone', 'location', 'about']);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->id === auth()->id()) {
            flash()->error('Vous ne pouvez pas supprimer votre propre compte.');
            return;
        }
        $user->delete();
        flash()->success('Utilisateur supprimé avec succès.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'phone', 'location', 'about']);
    }
} 