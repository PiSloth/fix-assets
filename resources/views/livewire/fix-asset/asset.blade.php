<div x-data="{ open: false }">
    <div>
        <div class="flex justify-between h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
            <div class="flex gap-3">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('New Assembly') }}
                </h2>

                <x-wui-button label="New" @click="$openModal('newModal')" />
                <x-wui-button teal label="Get PDF" wire:click='getPdf' />
                <x-wui-button green label="Export Products" wire:click='exportProducts' />
            </div>

            <button
                class="px-3 py-1 -ml-4 text-gray-600 underline rounded shadow-lg cursor-pointer filter hover:text-blue-600"
                @click="open = true">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                        clisp-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- <div class="flex px-12 mx-auto mt-2 overflow-x-auto sm:w-full md:w-3/4">
            @foreach ($departments as $department)
                <div
                    class="content-center w-20 h-20 text-center rounded shadow-lg cursor-pointer hover:shadow-teal-900 bg-slate-100">
                    <span class="font-semibold text-teal-500 ">{{ $department->name }}</span>
                </div>
            @endforeach
        </div> --}}

        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <div class="p-4 bg-white dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search" wire:model.live='search'
                        class="block pt-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search Name/ Assem Code/ တာဝန်ခံ">
                </div>
            </div>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Code
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Remark
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Department
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Photo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        တာဝန်ခံ
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Active
                    </th>
                    <th scope="col" class="px-6 py-3 sr-only">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @forelse ($assemblies as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->code }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->latestVerify?->status == 'verified')
                                <p class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1" width="20" height="20" viewBox="0 0 256 256"
                                        xml:space="preserve">
                                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                            transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                            <path
                                                d="M 49.66 1.125 L 49.66 1.125 c 4.67 -2.393 10.394 -0.859 13.243 3.548 l 0 0 c 1.784 2.761 4.788 4.495 8.071 4.66 l 0 0 c 5.241 0.263 9.431 4.453 9.694 9.694 v 0 c 0.165 3.283 1.899 6.286 4.66 8.071 l 0 0 c 4.407 2.848 5.941 8.572 3.548 13.242 l 0 0 c -1.499 2.926 -1.499 6.394 0 9.319 l 0 0 c 2.393 4.67 0.859 10.394 -3.548 13.242 l 0 0 c -2.761 1.784 -4.495 4.788 -4.66 8.071 v 0 c -0.263 5.241 -4.453 9.431 -9.694 9.694 h 0 c -3.283 0.165 -6.286 1.899 -8.071 4.66 l 0 0 c -2.848 4.407 -8.572 5.941 -13.242 3.548 l 0 0 c -2.926 -1.499 -6.394 -1.499 -9.319 0 l 0 0 c -4.67 2.393 -10.394 0.859 -13.242 -3.548 l 0 0 c -1.784 -2.761 -4.788 -4.495 -8.071 -4.66 h 0 c -5.241 -0.263 -9.431 -4.453 -9.694 -9.694 l 0 0 c -0.165 -3.283 -1.899 -6.286 -4.66 -8.071 l 0 0 C 0.266 60.054 -1.267 54.33 1.125 49.66 l 0 0 c 1.499 -2.926 1.499 -6.394 0 -9.319 l 0 0 c -2.393 -4.67 -0.859 -10.394 3.548 -13.242 l 0 0 c 2.761 -1.784 4.495 -4.788 4.66 -8.071 l 0 0 c 0.263 -5.241 4.453 -9.431 9.694 -9.694 l 0 0 c 3.283 -0.165 6.286 -1.899 8.071 -4.66 l 0 0 c 2.848 -4.407 8.572 -5.941 13.242 -3.548 l 0 0 C 43.266 2.624 46.734 2.624 49.66 1.125 z"
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,131,249); fill-rule: nonzero; opacity: 1;"
                                                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                            <polygon
                                                points="36.94,66.3 36.94,66.3 36.94,46.9 36.94,46.9 62.8,35.34 72.5,45.04 "
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,119,227); fill-rule: nonzero; opacity: 1;"
                                                transform="  matrix(1 0 0 1 0 0) " />
                                            <polygon
                                                points="36.94,66.3 17.5,46.87 27.2,37.16 36.94,46.9 60.11,23.7 69.81,33.39 "
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                                transform="  matrix(1 0 0 1 0 0) " />
                                        </g>
                                    </svg>
                                    <span class="text-slate-500">Verified</span>
                                </p>
                            @else
                                <p class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1" width="20" height="20" viewBox="0 0 256 256"
                                        xml:space="preserve">
                                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                            transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                            <path
                                                d="M 40.513 41.614 c 2.452 2.125 2.458 5.665 0.005 7.79 c -4.107 3.558 -9.02 7.211 -9.777 17.146 c -0.047 0.611 0.451 1.133 1.064 1.133 l 27.292 0 c 0.613 0 1.111 -0.522 1.064 -1.133 c -0.757 -9.934 -5.67 -13.587 -9.777 -17.146 c -2.453 -2.126 -2.447 -5.666 0.006 -7.792 c 4.24 -3.673 9.337 -7.45 9.831 -18.138 c 0.028 -0.601 -0.465 -1.107 -1.067 -1.107 l -27.407 0 c -0.602 0 -1.095 0.506 -1.067 1.107 C 31.175 34.164 36.273 37.94 40.513 41.614 z"
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(181,0,219); fill-rule: nonzero; opacity: 1;"
                                                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                            <path
                                                d="M 88.711 60.078 l -7.712 -2.066 c -2.998 8.042 -8.643 14.735 -16.171 19.08 c -8.575 4.947 -18.557 6.261 -28.113 3.699 c -9.544 -2.557 -17.528 -8.69 -22.481 -17.268 c -4.953 -8.579 -6.272 -18.56 -3.715 -28.104 c 5.286 -19.73 25.638 -31.48 45.374 -26.197 c 5.004 1.341 9.596 3.678 13.647 6.945 l 3.104 2.502 l -5.721 5.721 h 16.556 V 7.835 l -5.262 5.262 l -2.52 -2.177 c -5.151 -4.45 -11.121 -7.606 -17.744 -9.382 C 54.067 0.497 50.161 0 46.318 0 C 26.449 0 8.218 13.278 2.836 33.361 c -3.106 11.59 -1.502 23.714 4.515 34.137 s 15.715 17.872 27.305 20.978 c 11.498 3.078 23.845 1.453 34.148 -4.495 C 78.174 78.57 85.143 70.17 88.711 60.078 z"
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(181,0,219); fill-rule: nonzero; opacity: 1;"
                                                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                        </g>
                                    </svg>
                                    <span
                                        class="text-red-300">{{ ucfirst($item->latestVerify?->status) ?? 'Unknown' }}</span>
                                </p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->remark }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->department->name }}
                        </td>
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->image }}"
                                class="w-20 h-20 rounded-md shadow-lg">
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->employee->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4">
                            <button wire:click="toggleActive({{ $item->id }})"
                                class="px-3 py-1 text-xs font-medium rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>

                        <td class="px-6 py-4">
                            {{-- <x-wui-button label="edit" wire:click='read({{ $item->id }})' /> --}}
                            <x-wui-button teal icon="eye" :href="route('assembly.detail', ['id' => $item->id])" />
                            {{-- <x-danger-button x-on:click.prevent="$dispatch('open-modal', 'confirm-item-delete')"
                                wire:click='setDelete({{ $item->id }})'>
                                delete</x-danger-button> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>There's no records</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        <div class="p-4">{{ $assemblies->links() }}</div>
    </div>

    {{-- New modal  --}}
    <x-wui-modal-card title="Create New Assembly" name="newModal">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <x-wui-input label="Name" wire:model='name' placeholder="Computer One Set" />
            <x-wui-input label="Remark" wire:model='remark' placeholder="Desktop & UPS & Others" />
            <div>
                <label for="branches" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    a Branch</label>
                <select id="branches" wire:model='branch_id'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Brnach</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                <span class="text-sm text-red-500">{{ $errors->first('branch_id') }}</span>
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
                <span class="text-sm text-red-500">{{ $errors->first('department_id') }}</span>
            </div>
            <x-wui-select label="Responsible to" placeholder="Sloth" :async-data="route('api.employees')" option-label="name"
                option-value="id" wire:model='employee_id' />
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
    <x-wui-modal-card title="Create a assembly" name="editModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-wui-input label="Name" wire:model='up_name' placeholder="eg. Humburger" />
            <x-wui-input label="Remark" wire:model='up_remark' placeholder="HM" />
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

    {{-- filter for assembly --}}
    <x-filter-sidebar>
        <!-- Department Filter -->
        <div class="mt-4">
            <select wire:model.live="department_filter" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" selected>All Branch</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Start Date & End Date -->
        {{-- <div class="grid grid-cols-1 gap-4 pt-4 border-t border-gray-200">
            <x-wui-datetime-picker placeholder="Start Date" parse-format="YYYY-MM-DD HH:mm"
                wire:model.live="start_date" without-time="true" />
            <x-wui-datetime-picker placeholder="End Date" parse-format="YYYY-MM-DD HH:mm" wire:model.live="end_date"
                without-time="true" />
        </div> --}}
    </x-filter-sidebar>
</div>


<script>
    Livewire.on('closeModal', (name) => {
        $closeModal(name);
    });

    Livewire.on('openModal', (name) => {
        $openModal(name);
    });
</script>
