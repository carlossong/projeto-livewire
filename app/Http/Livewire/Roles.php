<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Roles extends Component
{
    public $search;
    public Role $form;
    public array $permissions = [];
    public $openModalDelete = false;
    public $openModalCreate = false;
    public ?Role $roleToRemove = null;
    protected $listeners = ['delete'];

    public function doubleClick(Role $form)
    {
        $this->form = $form;
        $this->form->load('permissions');
        $this->permissions = $form->permissions()->pluck('id')->toArray();
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    protected function rules(): array
    {

        return [
            'form.title' => [
                'string',
                'required',
            ],
        ];
    }

    public function newRole(Role $role)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->form = $role;
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    public function save()
    {
        $this->validate();
        $this->form->save();
        $this->form->permissions()->sync($this->permissions);
        $this->openModalCreate = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Hierarquia salva com sucesso!',
            'text' => '',
        ]);
    }

    public function confirmingRoleDeletion(Role $role)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->roleToRemove = $role;
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Remover ' . $role->title .'?',
            'text' => '',
            'id' => $role->id,
        ]);
    }

    public function delete()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->roleToRemove->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário removido com sucesso!',
            'text' => '',
        ]);
    }

    public function mount(Role $form)
    {
        $this->form = $form;
    }

    public function getRolesProperty()
    {
        return Role::with('permissions')->where('title', 'like', '%'.$this->search.'%')->orWhere('id', 'like', '%'.$this->search.'%')->orderBy('title')->paginate(10);
    }

    public function render()
    {
        $this->allPermissions = Permission::pluck('title', 'id');
        return view('livewire.roles');
    }
}
