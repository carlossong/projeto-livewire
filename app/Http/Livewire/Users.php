<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search;
    public User $form;
    public $roles = 2;
    public string $password = '';
    public $openModalDelete = false;
    public $openModalCreate = false;
    public ?User $userToRemove = null;
    protected $listeners = ['delete'];

    public function mount(User $form)
    {
        $this->form = $form;
    }

    protected function rules(): array
    {
        if($this->form->id){
            return [
                'form.name' => [
                    'string',
                    'required',
                ],
                'form.email' => [
                    'email:rfc',
                    'required',
                    'unique:users,email,' . $this->form->id,
                ],
                'password' => [
                    'string',
                ],
            ];
        }
        return [
            'form.name' => [
                'string',
                'required',
            ],
            'form.email' => [
                'email:rfc',
                'required',
                'unique:users,email',
            ],
            'password' => [
                'string',
                'required',
            ],
        ];
    }

    public function doubleClick(User $form)
    {
        $this->form = $form;
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    public function edit(User $user)
    {
        $this->form = $user;
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    public function newUser(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->form = $user;
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    public function save()
    {
        $this->validate();
        if($this->password){
            $this->form->password = bcrypt($this->password);
        }
        $this->form->save();
        $this->form->roles()->sync($this->roles);
        $this->openModalCreate = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário cadastrado com sucesso!',
            'text' => '',
        ]);
    }

    public function confirmingUserDeletion(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->userToRemove = $user;
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Remover ' . $user->name .'?',
            'text' => '',
            'id' => $user->id,
        ]);
    }

    public function delete()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->userToRemove->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário removido com sucesso!',
            'text' => '',
        ]);
    }


    public function getUsersProperty()
    {
        return User::with('roles')->where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%')->orderBy('name')->paginate(10);
    }

    public function render()
    {

        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('livewire.users');
    }
}
