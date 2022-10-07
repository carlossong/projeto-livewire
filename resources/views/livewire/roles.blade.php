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
                    <button wire:click='newUser'
                        class="ml-4 relative inline-flex items-center justify-center p-0.5 my-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-500 group-hover:from-green-400 group-hover:to-blue-400 hover:text-white focus:ring-4 focus:outline-none focus:ring-indigo-200">
                        <span
                            class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-green-400 rounded-md group-hover:bg-opacity-0">
                            Novo
                        </span>
                    </button>
                    <a href="{{ route('roles') }}"
                        class="ml-4 relative inline-flex items-center justify-center p-0.5 my-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-indigo-400 to-blue-600 group-hover:from-indigo-400 group-hover:to-blue-400 hover:text-white focus:ring-4 focus:outline-none focus:ring-indigo-200">
                        <span
                            class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-indigo-400 rounded-md group-hover:bg-opacity-0">
                            Hierarquias
                        </span>
                    </a>
                    <x-jet-input type="text" wire:model.debounce.300ms="search" id="search" class="m-4"
                        type="text" placeholder="Buscar usuário" autocomplete="nope" />
                    <div x-data class="p-4 grid md:grid-cols-2 gap-4">
                        @foreach ($this->roles as $index => $role)
                            <div x-data="{ opened_tab: null }" class="flex flex-col">
                                <div class="flex flex-col border rounded shadow mb-2">
                                    <div @click="opened_tab = opened_tab == {{ $index }} ? null : {{ $index }} "
                                        class="text-sm font-medium text-gray-700 hover:text-gray-900 p-4 cursor-pointer flex justify-between hover:text-indigo-600 hover:text-base">
                                        {{ $role->title }}
                                    </div>
                                    <div x-show="opened_tab=={{ $index }}" class="p-4 pb-4 text-gray-500">
                                        <div class="flex justify-between"
                                            x-on:dblclick="$wire.doubleClick('{{ $role->id }}')">
                                            @foreach ($role->permissions as $permission)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-green-100 text-green-800 items-center">
                                                    {{ $permission->title }}
                                                </span>
                                            @endforeach
                                            <svg wire:click='confirmingUserDeletion({{ $role->id }})'
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
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
                        {{ $this->roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
