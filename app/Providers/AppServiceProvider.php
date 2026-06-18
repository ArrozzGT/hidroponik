<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            ['layouts.petani', 'layouts.admin', 'layouts.pembeli'],
            \App\View\Composers\LayoutComposer::class
        );
    }
}
