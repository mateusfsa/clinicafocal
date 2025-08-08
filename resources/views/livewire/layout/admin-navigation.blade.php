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

<!-- Menu Responsivo Lateral -->
<nav class="mt-8">
    <ul>
        <li>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                <i class="fa-solid fa-gauge p-2"></i>
                <span class="ml-3 font-medium">{{ __('Dashboard') }}</span>
            </x-nav-link>
        </li>
        <li>
            <x-nav-link :href="route('admin.menu-itens')" :active="request()->routeIs('admin.menu-itens')" wire:navigate>
                <i class="fa-solid fa-bars p-2"></i>
                <span class="ml-3 font-medium">{{ __('Itens de Menu') }}</span>
            </x-nav-link>
        </li>
        <li>
            <x-nav-link :href="route('admin.hero-section-manager')" :active="request()->routeIs('admin.hero-section-manager')" wire:navigate>
                <i class="fa-solid fa-person-through-window p-2"></i>
                <span class="ml-3 font-medium">{{ __('Seção Hero') }}</span>
            </x-nav-link>
        </li>
    </ul>
</nav>
