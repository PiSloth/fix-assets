<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9 dark:text-gray-200" />
                    </a>
                </div>

                {{-- Config links  --}}
                @haspermission('company_access')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                        <div x-data="{ name: 'Company' }" x-text="name"
                                            x-on:profile-updated.window="name = $event.detail.name"></div>
                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <!--Shop or Branch -->
                                    <x-dropdown-link :href="route('branch')" wire:navigate>
                                        {{ 'Branch' }}
                                    </x-dropdown-link>

                                    <!--Department -->
                                    <x-dropdown-link :href="route('department')" wire:navigate>
                                        {{ 'Department' }}
                                    </x-dropdown-link>
                                    <!--Position -->
                                    <x-dropdown-link :href="route('position')" wire:navigate>
                                        {{ 'Position' }}
                                    </x-dropdown-link>

                                    <!--Employee -->
                                    <x-dropdown-link :href="route('employee')" wire:navigate>
                                        {{ 'Employee' }}
                                    </x-dropdown-link>

                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endhaspermission

                {{-- Config links  --}}

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                    <div x-data="{ name: 'Configuration' }" x-text="name"
                                        x-on:profile-updated.window="name = $event.detail.name"></div>
                                    <div class="ms-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Accessory Group-->
                                <x-dropdown-link :href="route('accessory-config')" wire:navigate>
                                    {{ 'Accessory Group' }}
                                </x-dropdown-link>
                                <!-- Accessory -->
                                <x-dropdown-link :href="route('accessory')" wire:navigate>
                                    {{ 'Accessory' }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>


                {{-- Config links  --}}

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                    <div x-data="{ name: 'Assets' }" x-text="name"
                                        x-on:profile-updated.window="name = $event.detail.name"></div>
                                    <div class="ms-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Accessory Group-->
                                <x-dropdown-link :href="route('assets')" wire:navigate>
                                    {{ 'Fix Assets' }}
                                </x-dropdown-link>
                                <!-- Accessory -->
                                {{-- <x-dropdown-link :href="route('accessory')" wire:navigate>
                                      {{ 'Accessory' }}
                                  </x-dropdown-link> --}}
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>


                {{-- Setting links  --}}
                @if (auth()->user()->hasAnyRole(['admin']))
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                        <div x-data="{ name: 'Setting' }" x-text="name"
                                            x-on:profile-updated.window="name = $event.detail.name"></div>
                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <!--User create List -->
                                    <x-dropdown-link :href="route('user-setting')" wire:navigate>
                                        {{ __('User') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('user-permission')" wire:navigate>
                                        {{ __('Role & Permission') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endif
            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>
                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>


        <!-- Responsive Company Options -->
        @haspermission('company_access')
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="text-base font-medium text-teal-600 dark:text-gray-200" x-data="{ name: 'Config' }"
                        x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="text-sm font-medium text-gray-500">Conguration of your business</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('branch')" wire:navigate>
                        {{ __('Branch') }}
                    </x-responsive-nav-link>
                    <!--Department -->
                    <x-responsive-nav-link :href="route('department')" wire:navigate>
                        {{ 'Department' }}
                    </x-responsive-nav-link>
                    <!--Position -->
                    <x-responsive-nav-link :href="route('position')" wire:navigate>
                        {{ 'Position' }}
                    </x-responsive-nav-link>

                    <!--Employee -->
                    <x-responsive-nav-link :href="route('employee')" wire:navigate>
                        {{ 'Employee' }}
                    </x-responsive-nav-link>

                </div>
            </div>
        @endhaspermission

        <!-- Responsive Accessories Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-base font-medium text-teal-600 dark:text-gray-200" x-data="{ name: 'Config' }"
                    x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">Classify Accessory Groups</div>
            </div>
            <div class="mt-3 space-y-1">
                <!-- Accessory Group-->
                <x-responsive-nav-link :href="route('accessory-config')" wire:navigate>
                    {{ 'Accessory Group' }}
                </x-responsive-nav-link>
                <!-- Accessory -->
                <x-responsive-nav-link :href="route('accessory')" wire:navigate>
                    {{ 'Accessory' }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('assets')" wire:navigate>
                    {{ 'Fix Assets' }}
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive User Setting Options -->
        {{-- <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-base font-medium text-teal-600 dark:text-gray-200" x-data="{ name: 'Setting' }"
                    x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">User Control & Permission</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('user-setting')" wire:navigate>
                    {{ __('Accounts') }}
                </x-responsive-nav-link>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('user-permission')" wire:navigate>
                    {{ __('Role & Permission') }}
                </x-responsive-nav-link>
            </div>
        </div> --}}

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800 dark:text-gray-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                    x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>

    </div>
</nav>
