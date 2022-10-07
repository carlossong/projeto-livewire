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
                    <li class="inline-flex items-center">
                        <a href="{{ route('users') }}">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd">
                                    </path>
                                </svg>
                                <span
                                    class="ml-1 text-sm font-medium text-gray-700 md:ml-2 dark:text-gray-900">Usuários</span>
                            </div>
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <a href="{{ route('roles') }}">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd">
                                    </path>
                                </svg>
                                <span
                                    class="ml-1 text-sm font-medium text-gray-700 md:ml-2 dark:text-gray-900">Hierarquias</span>
                            </div>
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
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Permissões</span>
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
                    <button wire:click='newPermission'
                        class="ml-4 relative inline-flex items-center justify-center p-0.5 my-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-500 group-hover:from-green-400 group-hover:to-blue-400 hover:text-white focus:ring-4 focus:outline-none focus:ring-indigo-200">
                        <span
                            class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-green-400 rounded-md group-hover:bg-opacity-0">
                            Nova
                        </span>
                    </button>
                    <x-jet-input type="text" wire:model.debounce.300ms="search" id="search" class="m-4"
                        type="text" placeholder="Buscar por nome" autocomplete="nope" />
                    <div x-data class="p-4 grid md:grid-cols-2 gap-4">
                        @foreach ($this->permissions as $index => $permission)
                            <div x-data="{ opened_tab: null }" class="flex flex-col">
                                <div class="flex flex-col border rounded shadow mb-2">
                                    <div @click="opened_tab = opened_tab == {{ $index }} ? null : {{ $index }} "
                                        class="text-sm font-medium text-gray-700 hover:text-gray-900 p-4 cursor-pointer flex justify-between hover:text-indigo-600 hover:text-base">
                                        {{ $permission->title }}
                                    </div>
                                    <div x-show="opened_tab=={{ $index }}" class="p-4 pb-4 text-gray-500">
                                        <div class="flex justify-end">
                                            <span class="m-2 text-xs text-gray-500 hover:text-gray-700 cursor-pointer" wire:click='edit({{ $permission->id }})'>Editar</span>
                                            <span class="m-2 text-xs text-red-500 hover:text-red-700 cursor-pointer" wire:click='confirmingPermissionDeletion({{ $permission->id }})'>Apagar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="m-4">
                        {{ $this->permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New User Modal -->
    <x-jet-dialog-modal wire:model="openModalCreate">
        <x-slot name="title">
            @if ($form->id)
                {{ __('Editar Permissão: ') }} {{ $form->title }}
            @else
                {{ __('Nova Permissão') }}
            @endif
        </x-slot>

        <x-slot name="content">

            <div class="space-y-4">

                <!-- Title -->
                <div class="mt-2">
                    <x-jet-label for="form.title" value="{{ __('Título') }}" />
                    <x-jet-input id="form.title" type="text" class="block w-full" wire:model.defer="form.title"
                        autocomplete="form.title" placeholder="Título" />
                    <x-jet-input-error for="form.title" class="mt-2" />
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
