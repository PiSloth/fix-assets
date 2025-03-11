<div x-data="{ open: false, }">
    <div class="flex h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('User Control') }}
        </h2>
        <x-wui-button label="Add" @click="open = !open" />
    </div>

    <form wire:submit='create' style="display: none" x-show="open" class="w-1/2 mx-auto" x-transition>
        <x-wui-input wire:model='name' type="text" label="Name" />
        <x-wui-input wire:model='email' type="email" label="email" />
        <x-wui-input wire:model.live='password' type="password" label="Password" />
        <x-wui-input wire:model.live='password_confirmation' type="password" label="Confirm password" />
        <span class="mt-2 text-sm text-red-400 ">{{ $pw_message }}</span>
        <div class="mt-4">
            <x-primary-button type="submit">Save</x-primary-button>
            <x-danger-button type="button" @click="open = false">cancle</x-danger-button>
        </div>
    </form>
    <div class="px-12 mt-2 overflow-x-auto" x-show="!open" style="display: none" x-transition>
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>

                    <th scope="col" class="px-6 py-3">
                        E mail
                    </th>

                    <th scope="col" class="px-6 py-3 sr-only">
                        Action
                    </th>

                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        @php
                            $branch_name = $user->userBranch->branch->name ?? 'Undefined';
                        @endphp
                        <td class="px-6 py-4">
                            <x-primary-button
                                wire:click='initializeUserData({{ $user->id }})'>Role</x-primary-button>
                            @if ($branch_name == 'Undefined')
                                <x-secondary-button wire:click='selectUser({{ $user->id }})'
                                    @click="$openModal('assignModal')">assign</x-secondary-button>
                            @else
                                <x-secondary-button wire:click='selectUser({{ $user->id }})'
                                    @click="$openModal('assignModal')">change</x-secondary-button>
                                {{ $branch_name }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>There's no records</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>


    {{-- New modal  --}}
    <x-wui-modal-card title="Assign to New Branch" name="assignModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <select wire:model.live='branch_id' required id="branch_name"
                    class="text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" disabled>Shop</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('assignModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />

                <x-wui-button primary label="Save" wire:click="assignBranch" />
            </div>
        </x-slot>
    </x-wui-modal-card>


    {{-- Roel modal  --}}
    <x-wui-modal-card title="Assigned Role" name="roleModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <span>{{ $user_data->name ?? '' }}</span>
            <span>{{ $user_data->email ?? '' }}</span>
        </div>
        <div class="p-4 my-4 rounded gb-gray-50">
            <span class="block mb-2 text-xl text-teal-500">Assigned Roles</span>
            @if ($user_data)
                @foreach ($user_data->roles as $role)
                    <li class="cursor-pointer hover:text-red-500"
                        wire:click='removeAssignRoleConfirm({{ $role->id }})'>
                        #{{ $role->name }}
                    </li>
                @endforeach
            @endif
        </div>
        <div>
            <select wire:model='role_id' required id="role"
                class="text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" selected disabled>Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
                <span class="text-sm text-red-200">{{ $message }}</span>
            @enderror
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('roleModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />

                <x-wui-button primary label="Save" wire:click="assignRole" />
            </div>
        </x-slot>
    </x-wui-modal-card>
</div>
<script>
    Livewire.on('openModal', (name) => {
        $openModal(name);
    });
    Livewire.on('closeModal', (name) => {
        $closeModal(name);
    });
</script>
