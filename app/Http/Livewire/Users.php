<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search;
    public User $form;
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
        $this->openModalCreate = false;
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Usuário salvo com Sucesso!'
        ]);
    }

    public function confirmingUserDeletion(User $user)
    {
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
        $this->userToRemove->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário removido com sucesso!',
            'text' => '',
        ]);
    }


    public function getUsersProperty()
    {
        return User::where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%')->orderBy('name')->paginate(10);
    }

    public function render()
    {
        return view('livewire.users');
    }
}
