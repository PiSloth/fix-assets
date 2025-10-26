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
                    @haspermission('admin')
                        <th scope="col" class="px-6 py-3">
                            Active
                        </th>
                    @endhaspermission
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
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Verified
                                </span>
                            @elseif($item->latestVerify?->status == 'pending')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Pending
                                </span>
                            @elseif($item->latestVerify?->status == 'rejected')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Rejected
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Unknown
                                </span>
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
                        @haspermission('admin')
                            <td class="px-6 py-4">
                                <button wire:click="toggleActive({{ $item->id }})"
                                    class="px-3 py-1 text-xs font-medium rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                        @endhaspermission
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
                <option value="" selected>All Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Verify Status Filter -->
        <div class="mt-4">
            <select wire:model.live="verify_status_filter" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" selected>All Status</option>
                <option value="verified">Verified</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
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
