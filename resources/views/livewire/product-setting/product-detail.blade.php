<div>
    <div class="flex justify-between h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
        <div class="flex gap-3">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Detail') }}
            </h2>
            <x-wui-button label="Remark" @click="$openModal('newModal')" />
        </div>
    </div>




    <div class="grid grid-cols-2 gap-4 mb-3 md:grid-cols-3">
        @foreach ($product->images as $image)
            <div>
                <!-- Image Box -->
                <img src="{{ Storage::url($image->image) }}" alt="product name" class="h-auto max-w-full rounded-lg" />
                <!-- Close Button -->
            </div>
        @endforeach
    </div>



    <div class="w-full mx-auto md:w-1/2">
        <div class="flex flex-wrap gap-2 mb-4">
            <span>Product Name: </span>
            <span class="text-blue-500">{{ $product->name }}</span>
            <span>Product Code: </span>
            <span class="text-teal-500">{{ $product->code }}</span>
            <span>Product Description: </span>
            <span>{{ $product->description }} </span>
        </div>
        @if ($product->remark)
            <div class="max-w-2xl px-8 py-4 mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <span
                        class="text-sm font-light text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($product->created_at)->format('j M y') }}</span>
                    <a class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-300 transform bg-gray-600 rounded cursor-pointer hover:bg-gray-500"
                        tabindex="0" role="button">Auto</a>
                </div>

                <div class="mt-2">
                    <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $product->remark }}</p>
                </div>
            </div>
        @endif
        {{-- Original --}}
        @foreach ($product->remarks as $item)
            <div class="max-w-2xl px-8 py-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <span
                        class="text-sm font-light text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($item->created_at)->format('j M y') }}</span>
                    <a class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-300 transform bg-gray-600 rounded cursor-pointer hover:bg-gray-500"
                        tabindex="0" role="button">{{ $item->type }}</a>
                </div>

                <div class="mt-2">
                    <a href="#"
                        class="text-xl font-bold text-gray-700 dark:text-white hover:text-gray-600 dark:hover:text-gray-200 hover:underline"
                        tabindex="0" role="link">Remark to {{ $item->employee->name ?? 'N/A' }}</a>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $item->remark }}</p>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline" tabindex="0"
                        role="link">-</a>

                    <div class="flex items-center">
                        <img class="hidden object-cover w-10 h-10 mx-4 rounded-full sm:block"
                            src="https://images.unsplash.com/photo-1502980426475-b83966705988?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=40&q=80"
                            alt="avatar">
                        <a class="font-bold text-gray-700 cursor-pointer dark:text-gray-200" tabindex="0"
                            role="link">{{ $item->user->name }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- New modal  --}}
    <x-wui-modal-card title="New Category" name="newModal">
        <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
            <x-wui-select label="Responsible to" placeholder="Sloth" :async-data="route('api.employees')" option-label="name"
                option-value="id" wire:model='employee_id' />
        </div>
        <x-wui-textarea label="Remark" wire:model='remark' placeholder="Cool note" />


        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('newModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />

                <x-wui-button primary label="Save" wire:click="createRemark" />

            </div>
        </x-slot>

    </x-wui-modal-card>


</div>
