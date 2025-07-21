<div>
    <div class="flex justify-between h-12 gap-2 p-3 mb-2 bg-white dark:text-white">
        <div class="flex gap-3">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Detail') }}
            </h2>
            @haspermission('edit_assembly')
                <x-wui-button lemon label="Edit Product" wire:click='setUpdateData' />
            @endhaspermission
            @if ($product->purchase_price == 0)
                <x-wui-button teal label="Purchase info" @click="$openModal('purchaseModal')" />
            @endif
            {{-- <x-wui-button label="Remark" @click="$openModal('newModal')" /> --}}
        </div>
    </div>


    <div class="bg-gray-100">
        <div class="container px-4 py-8 mx-auto">
            <div class="flex flex-wrap -mx-4">
                <!-- Product Images -->
                <div class="w-full px-4 mb-8 md:w-1/2">
                    <img src="{{ Storage::url($product->images->first()->image) }}" alt="Product"
                        class="w-full h-auto mb-4 rounded-lg shadow-md" id="mainImage">

                    <div class="flex justify-center gap-4 py-4 overflow-x-auto">
                        @foreach ($product->images as $image)
                            <div class="relative overflow-hidden rounded-md cursor-pointer size-16 sm:size-20 group">
                                <img src="{{ Storage::url($image->image) }}" alt="Image"
                                    onclick="changeImage(this.src)"
                                    class="object-cover w-full h-full transition duration-300 rounded-md opacity-60 group-hover:opacity-100">

                                <button wire:click="deletePhotoConfirmation({{ $image->id }})"
                                    class="absolute px-2 py-1 text-xs text-white transition duration-300 bg-red-400 rounded-md shadow-md opacity-0 top-2 right-2 group-hover:opacity-100">
                                    x
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Product Details -->
                <div class="w-full px-4 md:w-1/2">
                    <div>
                        <div class="">{!! DNS2D::getBarcodeHTML("$product->code", 'QRCODE') !!}</div>
                        <span> {{ $product->code ?? '' }}</span>
                    </div>
                    <h2 class="mb-2 text-3xl font-bold">{{ $product->name }}</h2>
                    <p class="mb-4 text-gray-600">{{ $product->serial_number ?? 'S/N' }}</p>
                    <div class="mb-4">
                        <span class="mr-2 text-2xl font-bold">{{ $product->purchase_price ?? '-' }} $</span>
                        {{-- <span class="text-gray-500 line-through">$399.99</span> --}}
                    </div>

                    <p class="mb-6 text-gray-700">{{ $product->description }}</p>


                    <div class="flex mb-6 space-x-4">

                        <button
                            class="flex items-center gap-2 px-6 py-2 text-gray-800 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                            favourite
                        </button>
                    </div>

                    <div>
                        <h3 class="mb-2 text-lg font-semibold">Product Remark</h3>
                        <ul class="text-gray-700 list-disc list-inside">
                            <li>{{ $product->remark }}</li>
                            {{-- {{-- <li>30-hour battery life</li> --}}
                            <li>Purchase at
                                {{ \Carbon\Carbon::parse($product->purchase_date)->format('j M, y') ?? '-' }}</li>
                            <li>Warranty expire at
                                {{ \Carbon\Carbon::parse($product->warranty_date)->format('j M, y') ?? '-' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 bg-gray-100">
        <h2 class="mb-4 text-lg font-bold">Comments</h2>
        <div class="flex flex-col space-y-4">
            @foreach ($product->remarks as $comment)
                <div class="p-4 bg-white rounded-lg shadow-md">
                    <span>တာဝန်ခံ - </span>
                    @if ($comment->employee_id > 0)
                        <h3 class="text-lg font-bold">{{ $comment->employee->name }}</h3>
                    @endif
                    <hr />
                    <span class="text-gray-700">{{ $comment->user->name }}<i>: commenter</i></span>
                    <p class="mb-2 text-sm text-gray-700">Posted on ({{ $comment->created_at->format('j M y') }})</p>
                    <p class="text-gray-700">{{ $comment->remark }}</p>
                </div>
            @endforeach

            @forelse ($product->stockTransfer as $item)
                <div class="p-4 bg-pink-300 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold">{{ $item->user->name }}</h3>
                    <p class="mb-2 text-sm text-gray-700">Transfered on ({{ $item->created_at->format('j M y') }})</p>
                    <p class="text-gray-700">{{ $item->remark }}</p>
                </div>
            @empty
                <p class="text-gray-400">Not transfer record</p>
            @endforelse

            <form wire:submit='createRemark'
                class="p-4 rounded-lg shadow-md bg-slate-200 dark:bg-gray-500 dark:text-white">
                <h3 class="mb-2 text-lg font-bold">Add a comment</h3>
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700" for="name">
                        Name
                    </label>
                    <input
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="name" type="text" value="{{ auth()->user()->name }}" placeholder="Enter your name"
                        disabled>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700" for="comment">
                        Comment
                    </label>
                    <textarea wire:model='remark'
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="comment" rows="3" placeholder="Enter your comment"></textarea>
                </div>
                <button
                    class="px-4 py-2 font-bold text-white rounded bg-cyan-500 hover:bg-cyan-700 focus:outline-none focus:shadow-outline"
                    type="submit">
                    Submit
                </button>
            </form>
        </div>
    </div>

    {{-- Edit Product modal  --}}
    <x-wui-modal-card title="Product Info Update" name="editProductModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-wui-input label="Name" wire:model='up_product_name' placeholder="{{ $product->name }}" />
            <x-wui-input label="Description" wire:model='up_product_desc' placeholder="{{ $product->description }}" />
            <x-wui-input label="Serial Number" wire:model='up_product_serial'
                placeholder="{{ $product->serial_number }}" />
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="$closeModal('editModal')" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Update" wire:click="update" />
            </div>
        </x-slot>
    </x-wui-modal-card>

    {{-- Purchase modal  --}}
    <x-wui-modal-card title="Purchase Info" name="purchaseModal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-wui-currency prefix="MMK" label="Price" wire:model='purchase_price'
                placeholder="{{ $product->purchase_price }}" />
            <x-wui-datetime-picker wire:model="purchase_date" label="Purchase Date" placeholder="Purchase Date"
                without-timezone without-time="true" />
            <x-wui-datetime-picker wire:model="warranty_date" label="Warranty Expired Date"
                placeholder="Warranty Date" without-timezone without-time="true" />
        </div>

        <x-slot name="footer" class="flex justify-between gap-x-4">
            <x-wui-button flat negative label="Delete" x-on:click="close" />

            <div class="flex gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />
                <x-wui-button primary label="Update" wire:click="updatePurchaseInfo" />
            </div>
        </x-slot>
    </x-wui-modal-card>
</div>

<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    Livewire.on('closeModal', (name) => {
        $closeModal(name);
    });

    Livewire.on('openModal', (name) => {
        $openModal(name);
    });
</script>
