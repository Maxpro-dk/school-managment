<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\Auth;
use Livewire\Component;

class Logout extends Component
{
    public $type="";

     public function mount($type=""){
        $this->type = $type;
     }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
