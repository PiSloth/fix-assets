<div x-data="{ 'open': false }">
    <div class="flex h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('New Product') }}
        </h2>
        <x-wui-button label="New" @click="$openModal('newModal')" />
        @if (!$assembly->employee_id)
            <x-wui-button teal label="Responsible to" @click="$openModal('responsibleTo')" />
        @else
            <x-wui-button stone label="Transfer to" @click="$openModal('ownershipModal')" />
        @endif
        @haspermission('edit_assembly')
            <x-wui-button amber label="Edit Assem" @click="$openModal('editAssemblyModal')" />
        @endhaspermission

        <button class="px-3 py-1 text-gray-600 underline rounded shadow-lg cursor-pointer filter hover:text-blue-600"
            @click="open = true">
            info
        </button>
        <x-wui-button teal href="/pdf/{{ $assembly_id }}" label="PDF" />
    </div>


    {{-- Assembly Cober --}}
    <div class="bg-gray-50">
        <div class="w-11/12 py-8 m-auto md:py-16 lg:w-10/12 xl:w-1200">
            <div class="space-y-16">
                <div
                    class="space-y-8 text-center md:space-y-0 md:text-left md:space-x-16 md:justify-center md:flex md:items-center ">
                    <div class="w-full space-y-4 md:w-1/4">
                        <div>
                            <div class="">{!! DNS2D::getBarcodeHTML("$assembly->code", 'QRCODE') !!}</div>
                            <span> {{ $assembly->code ?? '' }}</span>
                        </div>
                        <h3 class="text-2xl font-medium">{{ $assembly->name ?? '' }}</h3>
                        <div class="grid grid-cols-1 gap-4 p-3 mb-2 bg-white rounded-lg dark:text-white">

                            <span> Branch: {{ $assembly->branch->name ?? '' }}</span>
                            <span> Department: {{ $assembly->department->name ?? '' }}</span>
                            @if ($assembly->employee_id)
                                <span> တာဝန်ခံ အမည်: {{ $assembly->employee->name ?? '' }}</span>
                                <span> တာဝန်ခံ ဖုန်း: {{ $assembly->employee->phone ?? '' }}</span>
                                <span> တာဝန်ခံ id: ED- {{ $assembly->employee->stt_id ?? '' }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="relative w-1/2 mx-auto overflow-hidden rounded-md cursor-pointer md:w-1/3 group">
                        <img src="{{ asset('storage/' . $assembly->image) }}" alt="assembly"
                            class="inset-0 object-cover w-full h-auto rounded-lg " />
                        <button @click="$openModal('assemblyImageUpload')"
                            class="absolute px-2 py-1 text-xs text-white transition duration-300 bg-red-400 rounded-md shadow-md opacity-0 top-2 right-2 group-hover:opacity-100">
                            Change Photo
                        </button>
                    </div>
                </div>

                <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Code
                            </th>
                            <th scope="col" class="px-6 py-3">
                                S/N
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Remark
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

                        @forelse ($products as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->code }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->serial_number }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->description }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->remark }}
                                </td>
                                <td class="px-6 py-4">
                                    <div wire:click="viewPhotos({{ $item->id }},'{{ $item->name }}')"
                                        class="cursor-pointer">image
                                        <img src="{{ Storage::url($item->images->first()->image) ?? '' }}"
                                            alt="{{ $item->images->first() }}"
                                            class="object-cover w-16 h-16 rounded-lg" />
                                        <span>{{ count($item->images) }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <x-wui-button
                                        wire:click="addProductModal({{ $item->id }},'{{ $item->name }}')"
                                        icon="plus" />
                                    <x-wui-button amber href="{{ route('product-view', ['id' => $item->id]) }}"
                                        icon="information-circle" />
                                    <x-wui-button teal icon="arrow-right"
                                        wire:click="initializeTransferModal({{ $item->id }})" />
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

        </div>
    </div>

    <div class="hidden">
        {{-- Template --}}
        <h1 class="mb-4 text-3xl font-bold text-center">Asset Ownership Form</h1>

        <!-- Employee Info -->
        <div class="max-w-4xl p-6 mx-auto mb-10 border rounded-lg shadow">
            <h2 class="mb-4 text-xl font-semibold">Employee Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <strong>Code :</strong>{{ $assembly->code ?? '' }}
                </div>
                <div><strong>Location :</strong>{{ $assembly->branch->name ?? '' }}</div>
                <div><strong>Department :</strong>{{ $assembly->department->name ?? '' }}</div>
                @if ($assembly->employee_id)
                    <div><strong>Employee Name:</strong> {{ $assembly->employee->name ?? '' }}</div>
                    <div><strong>Employee ID:</strong> {{ $assembly->employee->id ?? '' }}</div>
                    <div><strong>Phone:</strong>{{ $assembly->employee->phone ?? '' }}</div>
                @endif
            </div>
        </div>

        <!-- Asset Table -->
        <div class="max-w-6xl mx-auto overflow-x-auto">
            <h2 class="mb-4 text-xl font-semibold">Assigned Assets</h2>
            <table class="min-w-full text-sm border border-gray-300 table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left border">#</th>
                        <th class="px-4 py-2 text-left border">Asset Name</th>
                        <th class="px-4 py-2 text-left border">Description</th>
                        <th class="px-4 py-2 text-left border">Serial Number</th>
                        <th class="px-4 py-2 text-left border">Photo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $item)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $item->name }}</td>
                            <td class="px-4 py-2 border">{{ $item->description }}</td>
                            <td class="px-4 py-2 border">{{ $item->serial_number }}</td>
                            <td>
                                <div wire:click="viewPhotos({{ $item->id }},'{{ $item->name }}')"
                                    class="cursor-pointer">
                                    <img src="{{ Storage::url($item->images->first()->image) ?? '' }}"
                                        alt="{{ $item->images->first() }}" class="object-cover w-16 h-16 rounded-lg" />
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Signatures -->
        <div class="grid max-w-4xl grid-cols-2 gap-8 mx-auto mt-10">
            <div>
                <p class="mb-16 font-semibold">Employee Signature:</p>
                <div class="w-3/4 mt-8 border-t border-gray-700"></div>
                <p class="mt-2">Date: ____________</p>
            </div>
            <div>
                <p class="mb-16 font-semibold">Asset Manager Signature:</p>
                <div class="w-3/4 mt-8 border-t border-gray-700"></div>
                <p class="mt-2">Date: ____________</p>
            </div>
        </div>
    </div>


    {{-- New modal  --}}
    <x-wui-modal-card title="New Product" name="newModal">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <x-wui-input label="Name" wire:model='name' placeholder="inspiron 310" />
            <x-wui-input label="Serial No" wire:model='serial_number' placeholder="123456" />
        </div>
        <div class="grid-cols-1">
            <x-wui-textarea label="Description" wire:model='description' placeholder="i9 14 Gen with turbo boot!" />
        </div>
        <x-wui-textarea label="Remark" wire:model='remark' placeholder="All fine but ear jack fail" />

        <div>
            @if (!$image)
                <div class="col-span-1 sm:col-span-2">
                    <div x-data @click="$refs.fileInput.click()"
                        class="flex items-center justify-center h-64 col-span-1 bg-gray-100 shadow-md cursor-pointer group cursor-porinter sm:col-span-2 dark:bg-secondary-700 rounded-xl">
                        <div class="flex flex-col items-center justify-center">
                            <x-wui-icon name="cloud-arrow-up"
                                class="w-16 h-16 text-blue-600 group-hover:text-blue-900 dark:text-teal-600" />
                            <p class="text-blue-600 group-hover:text-blue-900 dark:text-teal-600">
                                Click or
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

    {{-- image upload modal  --}}
    <x-wui-modal-card title="Add Photo" name="imageUpload">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <span> {{ $product_name }}</span>
        </div>

        <div>
            @if (!$image)
                <div class="col-span-1 sm:col-span-2">
                    <div x-data @click="$refs.fileInput.click()"
                        class="flex items-center justify-center h-64 col-span-1 bg-gray-100 shadow-md cursor-pointer group cursor-porinter sm:col-span-2 dark:bg-secondary-700 rounded-xl">
                        <div class="flex flex-col items-center justify-center">
                            <x-wui-icon name="cloud-arrow-up"
                                class="w-16 h-16 text-blue-600 group-hover:text-blue-900 dark:text-teal-600" />
                            <p class="text-blue-600 group-hover:text-blue-900 dark:text-teal-600">
                                Click or
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
            <x-wui-button flat negative label="Delete" x-on:click="close" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Save" wire:click="addPhoto" />
            </div>
        </x-slot>
    </x-wui-modal-card>

    {{-- assembly image upload modal  --}}
    <x-wui-modal-card title="Change New Photo" name="assemblyImageUpload">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <span> {{ $product_name }}</span>
        </div>

        <div>
            @if (!$update_assembly_image)
                <div class="col-span-1 sm:col-span-2">
                    <div x-data @click="$refs.fileInput.click()"
                        class="flex items-center justify-center h-64 col-span-1 bg-gray-100 shadow-md cursor-pointer group cursor-porinter sm:col-span-2 dark:bg-secondary-700 rounded-xl">
                        <div class="flex flex-col items-center justify-center">
                            <x-wui-icon name="cloud-arrow-up"
                                class="w-16 h-16 text-blue-600 group-hover:text-blue-900 dark:text-teal-600" />
                            <p class="text-blue-600 group-hover:text-blue-900 dark:text-teal-600">
                                Click or
                                drop files
                                here
                            </p>
                        </div>
                    </div>
                    <!-- Hidden file input -->
                    <input wire:model="update_assembly_image" id="image" accept="image" type="file"
                        x-ref="fileInput" class="hidden" />
                </div>
            @endif

            @if ($update_assembly_image)
                <div class="relative col-span-1 group sm:col-span-2">
                    <!-- Image Box -->
                    <img src="{{ $update_assembly_image->temporaryUrl() }}" alt="product name"
                        class="object-cover w-full h-32 rounded-lg" />

                    <!-- Close Button -->
                    <span wire:click='cancle_assembly_image'
                        class="absolute p-1 text-white transition bg-red-500 rounded-full opacity-0 cursor-pointer top-2 right-2 group-hover:opacity-100"
                        title="Remove image">
                        Cancle
                    </span>
                </div>
            @endif

            @error('update_assembly_image')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="close" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Update" wire:click="updateAssemblyImage" />
            </div>
        </x-slot>
    </x-wui-modal-card>

    {{-- View image modal  --}}
    <x-wui-modal-card title="All images" name="viewImage">
        @if (!empty($images))
            @foreach ($images as $image)
                <div class="relative col-span-1 mb-2 group sm:col-span-2">
                    <!-- Image Box -->
                    <img src="{{ Storage::url($image->image) }}" alt="product name" class="w-full rounded-lg" />
                    <!-- Close Button -->
                    <span
                        class="absolute p-1 text-white transition bg-teal-500 rounded-full opacity-0 cursor-pointer top-2 right-2 group-hover:opacity-100"
                        title="Remove image">
                        Cool
                    </span>
                </div>
            @endforeach
        @endif
    </x-wui-modal-card>

    {{-- Responsible modal  --}}
    <x-wui-modal-card title="တာဝန်ခံရွေးပါ" name="responsibleTo">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <x-wui-select label="Responsible to" placeholder="Sloth" :async-data="route('api.employees')" option-label="name"
                option-value="id" wire:model='employee_id' />
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('responsibleTo')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Assign" wire:click="assign" />
            </div>
        </x-slot>
    </x-wui-modal-card>

    {{-- Edit Assembly modal  --}}
    <x-wui-modal-card title="Edit" name="editAssemblyModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-wui-input label="Name" wire:model='up_ass_name' placeholder="{{ $assembly->name }}" />
            <div>
                <label for="branches" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    a Branch</label>
                <select id="branches" wire:model='up_branch_id'
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
                <select id="departments" wire:model='up_dep_id'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <span class="text-sm text-red-500">{{ $errors->first('department_id') }}</span>
            </div>
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('editModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Update" wire:click="updateAssembly" />
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

    {{-- Trnasfer modal  --}}
    <x-wui-modal-card title="ပစ္စည်း နေရာ ပြောင်းရွေးခြင်း" name="transferModal">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <x-wui-select label="Transfer to" placeholder="m u t u" :async-data="route('api.assemblies')" option-label="name"
                option-value="id" wire:model='transfered_assembly_id' />
        </div>

        <x-wui-textarea label="Remark" wire:model="remark" />

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('responsibleTo')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Transfer" wire:click="transfer" />
            </div>
        </x-slot>
    </x-wui-modal-card>

    {{-- Ownership change modal --}}
    <x-wui-modal-card title="ပစ္စည်းတာဝန် လွှဲပြောင်းခြင်း" name="ownershipModal">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <x-wui-select label="Request to" placeholder="Approver" :async-data="route('api.users')" option-label="info"
                option-value="id" wire:model='approver_id' />
            <x-wui-input disabled value="{{ $assembly->employee->name }}" label="Own By" />
            <x-wui-input disabled wire:model='transferby_id' value="{{ $assembly->employee->name }}"
                label="Transfer By" />
            <x-wui-select label="Responsible to" placeholder="Hand over to" :async-data="route('api.employees')" option-label="name"
                option-value="id" wire:model='transferto_id' />
        </div>

        <x-wui-textarea label="Reason" wire:model="reason" />

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('ownershipModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Shift Owner" wire:click="ownerChange" />
            </div>
        </x-slot>
    </x-wui-modal-card>

    <x-wui-modal-card title="ပစ္စည်းတာဝန် လွှဲပြောင်းခြင်း အတည်ပြုမည်" name="approverModal">
        <div class="grid grid-cols-1">
            @if ($ownership_request)
                <div>
                    <span class="font-bold ">Owner :</span> {{ $ownership_request['ownby'] }}
                </div>
                <div>
                    <span class="font-bold ">Transfer to :</span> {{ $ownership_request['transferto'] }}
                </div>
                <div>
                    <span class="font-bold ">Approver :</span> {{ $ownership_request['approver'] }}
                </div>
                <div>
                    <span class="font-bold ">Post by : </span> {{ $ownership_request['postby'] }}
                </div>
                <div class="p-2 mt-2 rounded bg-slate-100">
                    <span class="font-bold ">{{ $ownership_request['reason'] }}</span>
                </div>
            @endif
        </div>
        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Reject" wire:click='rejectChanges' />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button green label="Accept" wire:click="approveChanges" />
            </div>
        </x-slot>

    </x-wui-modal-card>

    {{-- filter for assembly --}}
    <x-filter-sidebar title="Transaction Histories">
        <!-- Product Transfer Histories -->
        <div class="mt-4">
            @foreach ($transfers as $item)
                <div>
                    <img class="w-10 h-10 rounded-full"
                        src="{{ asset('storage/' . $item->product->images->first()->image) }}" />
                    <a href="#" class="text-gray-700">{{ $item->product->code }}</a>
                    <a href="{{ route('assembly.detail', ['id' => $item->transfered_assembly_id]) }}"> =>
                        <span class="text-pink-400">{{ $item->transferedAssembly->code }}</span></a>
                    <span class="italic text-gray-400">Transfer at {{ $item->created_at }}</span> By
                    <span class="text-blue-400">{{ $item->user->name }}</span>
                </div>
                <hr />
            @endforeach
        </div>
        {{-- Ownership changes histories --}}
        <div class="mt-4">
            @foreach ($ownership_changes as $item)
                <div class="p-4 mb-2 rounded shadow-sm bg-slate-100 hover:cursor-pointer">
                    <span @click="open = false"
                        wire:click='readOwnership({{ $item->id }})'>{{ $item->transferby->name }} posted to
                        transfer this assembly from
                        {{ $item->ownby->name }}
                        to {{ $item->transferto->name }}.</span>

                    <br />

                    <span class="italic text-gray-400">{{ $item->created_at->format('j M y') }}</span> Request to
                    <span class="text-blue-400"> {{ $item->approver->name }}</span>

                    @if ($item->status == 'approve')
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">{{ $item->status }}</span>
                    @elseif($item->status == 'reject')
                        <span
                            class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">{{ $item->status }}</span>
                    @else
                        <span
                            class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">{{ $item->status }}</span>
                    @endif
                    <x-wui-mini-button rounded icon="bookmark" flat gray hover:outline.negative focus:solid.positive
                        href="/pdf/ownership/{{ $item->id }}" />
                </div>
                <hr />
            @endforeach
        </div>
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
