<?php

namespace App\Providers;

use App\Listeners\RegistrarAcesso;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log de acessos (login, logout e tentativas falhas)
        Event::listen(Login::class, RegistrarAcesso::class);
        Event::listen(Logout::class, RegistrarAcesso::class);
        Event::listen(Failed::class, RegistrarAcesso::class);
    }
}
