<div>
    <div>
        <div class="flex h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('New Accessory') }}
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
                            Group
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Code
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Photo
                        </th>

                        <th scope="col" class="px-6 py-3 sr-only">
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($accessories as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->accessoriesGroup->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->code }}
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->image }}"
                                    class="w-20 h-20 rounded-md shadow-lg">
                            </td>

                            <td class="px-6 py-4">
                                <x-wui-button label="edit" wire:click='read({{ $item->id }})' />
                                <x-danger-button x-on:click.prevent="$dispatch('open-modal', 'confirm-item-delete')"
                                    wire:click='setDelete({{ $item->id }})'>
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
            <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
                <x-wui-input label="Name" wire:model='name' placeholder="eg. Computer" />
                <x-wui-input label="Code" wire:model='code' placeholder="eg C" />
                <x-wui-select label="Choose Group" placeholder="Electronics" :async-data="route('api.accessories-group')" option-label="name"
                    option-value="id" wire:model='accessories_group_id' />
            </div>

            <div>

                @if (!$image)
                    <div class="col-span-1 sm:col-span-2">
                        <div x-data @click="$refs.fileInput.click()"
                            class="flex items-center justify-center h-64 col-span-1 bg-gray-100 shadow-md cursor-pointer group cursor-porinter sm:col-span-2 dark:bg-secondary-700 rounded-xl">
                            <div class="flex flex-col items-center justify-center">
                                <x-wui-icon name="cloud-arrow-up"
                                    class="w-16 h-16 text-blue-600 group-hover:text-blue-900 dark:text-teal-600" />
                                <p class="text-blue-600 group-hover:text-blue-900 dark:text-teal-600">Click or
                                    drop files
                                    here
                                </p>
                            </div>
                        </div>
                        <!-- Hidden file input -->
                        <input wire:model="image" id="image" accept="image/jpeg,image/jpg" type="file"
                            x-ref="fileInput" class="hidden" />
                    </div>
                @endif

                @if ($image)
                    <div class="relative col-span-1 group sm:col-span-2">
                        <!-- Image Box -->
                        <img src="{{ $image->temporaryUrl() }}" alt="product name"
                            class="object-cover w-full h-32 rounded-lg" />

                        <!-- Close Button -->
                        <span wire:click='cancle_image'
                            class="absolute p-1 text-white transition bg-red-500 rounded-full opacity-0 cursor-pointer top-2 right-2 group-hover:opacity-100"
                            title="Remove image">
                            Cancle
                        </span>
                    </div>
                @endif

                @error('image')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
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
                <x-wui-input label="Phone" wire:model='up_code' placeholder="HM" />
            </div>

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <x-wui-button flat negative label="Delete" x-on:click="$closeModal('editModal')" />

                <div class="flex gap-x-4">
                    <x-wui-button flat label="Cancel" x-on:click="close" />
                    <x-wui-button primary label="Update" wire:click="update" />
                </div>
            </x-slot>
        </x-wui-modal-card>

        <x-modal name="confirm-item-delete" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit="delete" class="p-6">

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete Branch?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your item is deleted, all of its porducts and data will be permanently deleted.') }}
                </p>

                <div class="flex justify-end mt-6">
                    <x-secondary-button wire:click='cancleDelete' x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete item') }}
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
