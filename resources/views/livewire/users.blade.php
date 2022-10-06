<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Usuários</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="shadow-lg rounded-lg overflow-hidden">
                    <x-jet-input type="text" wire:model.debounce.300ms="search" id="search" class="m-4"
                        type="text" placeholder="Buscar usuário" autocomplete="nope" />
                    <div x-data class="p-4 grid md:grid-cols-2 gap-4">
                        @foreach ($this->users as $index => $user)
                            <div x-data="{ opened_tab: null }" class="flex flex-col">
                                <div class="flex flex-col border rounded shadow mb-2">
                                    <div @click="opened_tab = opened_tab == {{ $index }} ? null : {{ $index }} "
                                        class="text-sm font-medium text-gray-700 hover:text-gray-900 p-4 cursor-pointer flex hover:text-indigo-600 hover:text-lg">
                                        {{ $user->name }}
                                    </div>
                                    <div x-show="opened_tab=={{ $index }}" class="p-4 pb-4 text-gray-500">
                                        <div class="flex justify-between"
                                            x-on:dblclick="$wire.doubleClick('{{ $user->id }}')">
                                            <p>{{ $user->email }}</p>
                                            <svg wire:click='confirmingUserDeletion({{ $user->id }})' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6 hover:text-red-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="m-4">
                        {{ $this->users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- New User Modal -->
     <x-jet-dialog-modal wire:model="openModalCreate">
        <x-slot name="title">
            @if ($form->id)
                {{ __('Editar Usuário: ') }} {{ $form->name }}
            @else
                {{ __('Novo Usuários') }}
            @endif
        </x-slot>

        <x-slot name="content">

            <div class="space-y-4">

                <!-- Name -->
                <div class="mt-2">
                    <x-jet-label for="form.name" value="{{ __('Name') }}" />
                    <x-jet-input id="form.name" type="text" class="block w-full" wire:model.defer="form.name"
                        autocomplete="form.name" placeholder="Nome do cliente" />
                    <x-jet-input-error for="form.name" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-2">
                    <x-jet-label for="form.email" value="{{ __('Email') }}" />
                    <x-jet-input id="form.email" type="email" class="block w-full" wire:model.defer="form.email"
                        autocomplete="form.email" placeholder="E-mail" />
                    <x-jet-input-error for="form.email" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-2 gap-2">
                    <x-jet-label for="password" value="{{ __('Senha') }}" />
                    <x-jet-input id="password" type="password" class="block w-full" wire:model.defer="password"
                        autocomplete="password" placeholder="Senha" />
                    <x-jet-input-error for="password" class="mt-2" />
                </div>
                <div class="mt-2"></div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('openModalCreate')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                {{ __('Salvar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
