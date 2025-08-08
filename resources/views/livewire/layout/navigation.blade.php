<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }"
    class="fixed top-0 left-0 h-full w-56 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 z-50">
    <div class="max-h-full overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200">
        <!-- Logo -->
        <div class="fixed items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700 p-2">
            <a href="{{ route('dashboard') }}" wire:navigate>
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200 m-2" />
            </a>
        </div>
        <div class="flex-row py-16">
            <!-- Navigation Links -->
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    <i class="fa-solid fa-gauge p-2"></i>
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('admin.menu-itens')" :active="request()->routeIs('admin.menu-itens')" wire:navigate>
                    <i class="fa-solid fa-bars p-2"></i>
                    {{ __('Itens de Menu') }}
                </x-nav-link>
            </div>
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('admin.hero-section-manager')" :active="request()->routeIs('admin.hero-section-manager')" wire:navigate>
                    <i class="fa-solid fa-person-through-window p-2"></i>
                    {{ __('Seção Hero') }}
                </x-nav-link>
            </div>
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('admin.about-section-manager')" :active="request()->routeIs('admin.about-section-manager')" wire:navigate>
                    <i class="fa-regular fa-address-card p-2"></i>
                    {{ __('Seção Sobre') }}
                </x-nav-link>
            </div>
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('admin.services-manager')" :active="request()->routeIs('admin.services-manager')" wire:navigate>
                    <i class="fa-brands fa-usps p-2"></i>
                    {{ __('Seção Serviços') }}
                </x-nav-link>
            </div>
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('admin.team-members-manager')" :active="request()->routeIs('admin.team-members-manager')" wire:navigate>
                    <i class="fa-brands fa-teamspeak p-2"></i>
                    {{ __('Seção Equipe') }}
                </x-nav-link>
            </div>
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('admin.testimonial-manager')" :active="request()->routeIs('admin.testimonial-manager')" wire:navigate>
                    <i class="fa-solid fa-comments p-2"></i>
                    {{ __('Seção Depoimentos') }}
                </x-nav-link>
            </div>
            <div class="mt-4 flex flex-col space-y-2 px-4">
                <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')" wire:navigate>
                    <i class="fa-solid fa-gears p-2"></i>
                    {{ __('Configuraçãos') }}
                </x-nav-link>
            </div>


            <!-- Settings Dropdown -->
            <div class="mt-auto px-4 py-4">
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button
                            class="w-full flex items-center justify-between px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name">
                            </div>
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            <i class="fa-solid fa-user p-2"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!--<livewire:component.theme-toggle />-->
                        <button wire:click="logout" class="w-full text-left">
                            <x-dropdown-link>
                                <i class="fa-solid fa-person-walking-arrow-right p-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
