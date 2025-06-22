<div class="fixed inset-0 z-50 flex" x-show="open" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <!-- Blurred Background -->
    <div class="fixed inset-0 bg-black/30" aria-hidden="true" @click="open = false"></div>

    <!-- Right Sidebar Panel with Scroll -->
    <div class="fixed top-0 right-0 flex flex-col h-full overflow-y-auto transition-transform duration-300 transform bg-white shadow-xl w-80"
        x-show="open" x-transition:enter="translate-x-full" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="translate-x-0"
        x-transition:leave-end="translate-x-full">

        <!-- Close Button -->
        <button type="button" @click="open = false"
            class="absolute z-10 p-2 text-gray-400 bg-white rounded-full shadow-md top-3 right-3">
            <span class="sr-only">Close menu</span>
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="sticky top-0 z-10 px-4 pt-16 pb-2 text-lg font-medium text-gray-900 bg-white">
            {{ $title }}
        </h2>

        <!-- Content with Scroll -->
        <div class="p-4 space-y-4">
            {{ $slot }}
        </div>
    </div>
</div>
