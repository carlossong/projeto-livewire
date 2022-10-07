<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Permissions extends Component
{
    public $search;
    public Permission $form;
    public $openModalDelete = false;
    public $openModalCreate = false;
    public ?Permission $roleToRemove = null;
    protected $listeners = ['delete'];

    public function edit(Permission $form)
    {
        $this->form = $form;
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

    public function newPermission(Permission $permission)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->form = $permission;
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    public function save()
    {
        $this->validate();
        $this->form->save();
        $this->openModalCreate = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Permissão salva com sucesso!',
            'text' => '',
        ]);
    }

    public function confirmingPermissionDeletion(Permission $permission)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->permissionToRemove = $permission;
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Remover ' . $permission->title .'?',
            'text' => '',
            'id' => $permission->id,
        ]);
    }

    public function delete()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->permissionToRemove->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Permissão removida com sucesso!',
            'text' => '',
        ]);
    }

    public function mount(Permission $form)
    {
        $this->form = $form;
    }

    public function getPermissionsProperty()
    {
        return Permission::where('title', 'like', '%'.$this->search.'%')->orWhere('id', 'like', '%'.$this->search.'%')->orderBy('title')->paginate(10);
    }

    public function render()
    {
        return view('livewire.permissions');
    }
}
