<?php

use App\Http\Middleware\CountSiteVisit;
use App\Livewire\Admin\HeroSectionManager;
use App\Livewire\Admin\MenuItems;
use App\Livewire\Admin\PacienteManager;
use App\Livewire\Admin\SettingsPanel;
use App\Models\Graduacoe;
use App\Models\Receita;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome');

Route::view('/', 'home');//->middleware(['count.site.visit'])->name('home');

// Admin Routes
/*
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/menu-itens', MenuItems::class)->name('admin.menu-itens');
    Route::get('/hero-section-manager', HeroSectionManager::class)->name('admin.hero-section-manager');
    Route::get('/about-section-manager', \App\Livewire\Admin\AboutSectionManager::class)->name('admin.about-section-manager');
    Route::get('/admin/services-manager', \App\Livewire\Admin\ServiceManager::class)->name('admin.services-manager');
    Route::get('/team-members-manager', \App\Livewire\Admin\TeamMembersManager::class)->name('admin.team-members-manager');
    Route::get('/testimonial-manager', \App\Livewire\Admin\TestimonialManager::class)->name('admin.testimonial-manager');
    Route::get('/settings', SettingsPanel::class)->name('admin.settings');
    Route::get('/pacientes', PacienteManager::class)->name('admin.pacientes');    
});
*/
/*
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
*/
/*
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

*/
Route::get('/print/graduacao/{graduacoe}', function (Graduacoe $graduacoe) {
    return view('prints.graduacao', ['graduacoe' => $graduacoe]);
})->name('print.graduacao');

Route::get('/print/receita/{receita}', function (Receita $receita) {
    return view('prints.receita', ['receita' => $receita]);
})->name('print.receita');

require __DIR__ . '/auth.php';
