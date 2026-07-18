<?php

namespace App\Filament\Pages\Cms;

use Filament\Pages\Page;

/**
 * Página base do CMS do site institucional.
 * Restrita a administradores.
 */
abstract class BaseCmsPage extends Page
{
    protected static ?string $navigationGroup = 'Site';

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
