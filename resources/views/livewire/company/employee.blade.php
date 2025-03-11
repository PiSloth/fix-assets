<div>
    <div>
        <div class="flex h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('New employee') }}
            </h2>
            <x-wui-button label="New" @click="$openModal('newModal')" />
        </div>

        <div class="px-12 mx-auto mt-2 overflow-x-auto sm:w-full md:w-3/4">
            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            STT ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Position
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 sr-only">
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $employee->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->stt_id }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $employee->phone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $employee->position->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $employee->department->name }}
                            </td>
                            <td class="px-6 py-4">
                                <x-wui-button label="edit" wire:click='edit({{ $employee->id }})' />
                                <x-danger-button x-on:click.prevent="$dispatch('open-modal', 'confirm-employee-delete')"
                                    wire:click='setDelete({{ $employee->id }})'>
                                    delete</x-danger-button>
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
        <x-wui-modal-card title="New Category" name="newModal">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-wui-input label="Name" wire:model='name' placeholder="eg. Sloth" />
                <x-wui-input label="ED" wire:model='stt_id' prefix="ED-" placeholder="49" />
                <x-wui-phone label="Phone" wire:model='phone' placeholder="eg. 09 14692468" />
                <div>
                    <label for="positions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        a position</label>
                    <select id="positions" wire:model='position_id'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Position</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="departments" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        a Department</label>
                    <select id="departments" wire:model='department_id'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <x-wui-button flat negative label="Delete" x-on:click="$closeModal('newModal')" />

                <div class="flex gap-x-4">
                    <x-wui-button flat label="Cancel" x-on:click="close" />

                    <x-wui-button primary label="Save" wire:click="create" />

                </div>
            </x-slot>
        </x-wui-modal-card>

        {{-- Edit modal  --}}
        <x-wui-modal-card title="New Category" name="editModal">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-wui-input label="Name" wire:model='up_name' placeholder="eg. Humburger" />
                <x-wui-phone label="Phone" wire:model='up_phone' placeholder="eg. 09 78788" />
                <x-wui-input label="Address" wire:model='up_address' placeholder=" eg . Hlaetan.Yangon" />

            </div>

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <x-wui-button flat negative label="Delete" x-on:click="$closeModal('editModal')" />

                <div class="flex gap-x-4">
                    <x-wui-button flat label="Cancel" x-on:click="close" wire:click='cancleEdit' />
                    <x-wui-button primary label="Update" wire:click="update" />
                </div>
            </x-slot>
        </x-wui-modal-card>

        <x-modal name="confirm-employee-delete" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit="delete" class="p-6">

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete employee?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your employee is deleted, all of its porducts and data will be permanently deleted.') }}
                </p>

                <div class="flex justify-end mt-6">
                    <x-secondary-button wire:click='cancleDelete' x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete employee') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>

    <script>
        Livewire.on('closeModal', (name) => {
            $closeModal(name);
        });

        Livewire.on('openModal', (name) => {
            $openModal(name);
        });
    </script>
</div>
