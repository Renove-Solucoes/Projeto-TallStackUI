<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TallStackUi\Facades\TallStackUi;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $blocks = [
            'desktop.wrapper.first.size',
            'desktop.wrapper.second',
            'desktop.wrapper.third',
            'desktop.wrapper.fourth',
            'desktop.wrapper.fifth',
            'desktop.collapse.wrapper',

        ];

        $sidebar = TallStackUi::personalize()->sideBar();

        foreach ($blocks as $block) {
            $sidebar->block($block, 'bg-dark-700');
        }
    }
}
