<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $search;
    public Role $form;

    public function getRolesProperty()
    {
        return Role::with('permissions')->where('title', 'like', '%'.$this->search.'%')->orWhere('id', 'like', '%'.$this->search.'%')->orderBy('title')->paginate(10);
    }

    public function render()
    {
        return view('livewire.roles');
    }
}
