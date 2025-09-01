<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TallStackUi\Facades\TallStackUi;
use TallStackUi\View\Components\Layout\SideBar\SideBar;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        date_default_timezone_set('America/Sao_Paulo');

        TallStackUi::personalize()
            ->layout()
            ->block('wrapper.second.expanded')
            ->replace([
                'md:pl-72' => 'md:pl-60',
            ]);

        TallStackUi::personalize()
            ->layout('header')
            ->block('wrapper')
            ->replace([
                'bg-white' => 'bg-dark-600',
            ]);
        TallStackUi::personalize()
            ->sideBar()
            ->block('desktop.sizes.expanded')->replace([
                'w-72' => 'w-60',
            ])
            ->block('desktop.wrapper.second')->replace([
                'bg-white' => 'bg-dark-600',
                'border-r' => 'border-0',
            ])->block('desktop.collapse.buttons.expanded.class')->replace([
                'dark:text-dark-300' => 'dark:text-dark-300/0',
                'text-primary-500' => 'text-primary-500/0',
            ])->block('desktop.collapse.buttons.collapsed.class')->replace([
                'dark:text-dark-300' => 'dark:text-dark-300/0',
                'text-primary-500' => 'text-primary-500/0',
            ]);


        TallStackUi::personalize()
            ->sideBar('item')
            ->block('item.state.normal')
            ->replace([
                'hover:bg-primary-50' => 'hover:bg-dark-400',
                'text-primary-500' => 'text-white',
            ])
            ->block('item.state.current')
            ->replace([
                'bg-primary-50' => 'bg-dark-500',
            ])
            ->block('item.icon')
            ->replace([
                'hover:bg-primary-50' => 'hover:bg-dark-200',
                'text-primary-500' => 'text-white',
            ]);

        // AppServiceProvider, "boot" method.

        TallStackUi::personalize()
            ->card()
            ->block('header.wrapper.border')->replace([
                'border-b' => 'border-b-0',
            ]);
    }
}
