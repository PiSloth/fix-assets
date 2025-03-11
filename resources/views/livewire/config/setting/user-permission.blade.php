<div>

    <div class="flex h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('User Roles & Permissions') }}
        </h2>
        <x-wui-button teal label="Add Role" @click="$openModal('newRoleModal')" />
        <x-wui-button label="Add Permission" @click="$openModal('newPermissionModal')" />
    </div>


    <div class="w-full p-8 mx-auto mt-4 sm:w-3/4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="relative flex flex-col w-full max-w-xs gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="modelName" class="w-fit pl-0.5 text-sm">Select Role</label>
                <select
                    class="w-full px-4 py-2 text-sm border rounded-md appearance-none border-neutral-300 bg-neutral-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                    wire:model.live='role_id'>
                    <option value='' selected disabled>Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- search input for permission  --}}
            {{-- <label for="search" class="w-fit pl-0.5 text-sm">Search a permission</label> --}}

            <div class="relative flex flex-col w-full max-w-xs gap-1 my-4 text-neutral-600 dark:text-neutral-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true"
                    class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50 dark:text-neutral-300/50">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="search" wire:model.live='search' id="search"
                    class="w-full py-2 pl-10 pr-2 text-sm border rounded-md border-neutral-300 bg-neutral-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                    name="search" placeholder="Search permission name" aria-label="search" />
            </div>
        </div>

        <span class="text-xl text-gray-400">Permissions</span>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            @forelse ($permissions_role as $permission)
                <div class="content-center p-4 rounded shadow-md cursor-pointer">
                    @if ($permission->status)
                        <!-- success Badge -->
                        <div wire:click='removeAssignPermissionConfirm({{ $permission->id }})'
                            class="inline-flex overflow-hidden font-medium text-green-500 bg-white border border-green-500 rounded-md group w-fit dark:border-green-500 dark:bg-neutral-950 dark:text-green-500">
                            <span class="flex items-center gap-1 px-2 py-1 bg-green-500/10 dark:bg-green-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                    fill="currentColor" class="size-4 group-hover:hidden">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="hidden text-red-500 group-hover:inline size-4" fill="currentColor"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ $permission->name }}
                            </span>
                        </div>
                    @else
                        <!-- unasign permission -->
                        <div wire:click='addAssignPermissionConfirm({{ $permission->id }})'
                            class="inline-flex overflow-hidden font-medium bg-white border rounded-md hover:bg-green-100 hover:text-green-500 group w-fit hover:border-green-600 border-amber-500 text-amber-500 dark:border-amber-500 dark:bg-neutral-950 dark:text-amber-500">
                            <span class="flex items-center gap-1 px-2 py-1 bg-amber-500/10 dark:bg-amber-500/10">
                                <svg class="group-hover:hidden size-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M11.484 2.17a.75.75 0 011.032 0 11.209 11.209 0 007.877 3.08.75.75 0 01.722.515 12.74 12.74 0 01.635 3.985c0 5.942-4.064 10.933-9.563 12.348a.749.749 0 01-.374 0C6.314 20.683 2.25 15.692 2.25 9.75c0-1.39.223-2.73.635-3.985a.75.75 0 01.722-.516l.143.001c2.996 0 5.718-1.17 7.734-3.08zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zM12 15a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75v-.008a.75.75 0 00-.75-.75H12z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="hidden text-green-500 group-hover:inline size-4" fill="currentColor"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ $permission->name }}
                            </span>
                        </div>
                    @endif

                </div>
            @empty
                <span class="text-sm text-red-200">Nothing to show.</span>
            @endforelse
        </div>
    </div>

    {{-- add role modal  --}}
    <x-wui-modal-card title="New Category" name="newRoleModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-wui-input label="Role" wire:model='name' placeholder="eg. Staff" />
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('newRoleModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Save" wire:keydown.enter='createRole' wire:click="createRole" />
            </div>
        </x-slot>
    </x-wui-modal-card>

    {{-- add permission modal  --}}
    <x-wui-modal-card title="New Category" name="newPermissionModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-wui-input label="Role" wire:model='name' placeholder="eg. User Creation" />
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('newPermissionModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Save" wire:click="createPermission" />
            </div>
        </x-slot>
    </x-wui-modal-card>
</div>
<script>
    Livewire.on('closeModal', (name) => {
        $closeModal(name);
    });

    Livewire.on('openModal', (name) => {
        $openModal(name);
    });
</script>
