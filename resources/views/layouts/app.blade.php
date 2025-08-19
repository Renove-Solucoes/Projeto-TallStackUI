<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <tallstackui:script />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-cloak x-data="{ name: @js(auth()->user()->name) }" x-on:name-updated.window="name = $event.detail.name"
  x-bind:class="{ 'dark bg-gray-600': darkTheme, 'bg-gray-400': !darkTheme }">
    <x-layout>
        <x-slot:top>
            <x-dialog />
            <x-toast />
        </x-slot:top>
        <x-slot:header>
            <x-layout.header>
                <x-slot:left>
                    <button x-on:click="$store['tsui.side-bar'].toggle()"
                        class="cursor-pointer absolute top-4 left-4 rounded-full p-1 bg-gray-700 hover:bg-gray-500 dark:bg-gray-600 dark:hover:bg-gray-500">

                        <svg class="w-5 h-5 text-dark-300 dark:text-dark-300" x-show="$store['tsui.side-bar'].open"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                                clip-rule="evenodd"></path>
                        </svg>


                        <svg class="w-5 h-5 text-dark-300 dark:text-dark-300" x-show="!$store['tsui.side-bar'].open"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" data-slot="icon" style="display: none;">
                            <path fill-rule="evenodd"
                                d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                                clip-rule="evenodd"></path>
                        </svg>



                    </button>
                </x-slot:left>
                <x-slot:right>
                    <div class="mr-4">
                        <x-theme-switch only-icons />
                    </div>
                    <x-avatar class="mr-2" :model="auth()->user()" color="fff" sm />

                    <x-dropdown>
                        <x-slot:action>
                            <div>
                                <button class="cursor-pointer" x-on:click="show = !show">
                                    <span class="text-base font-semibold text-primary-500" x-text="name"></span>
                                </button>
                            </div>
                        </x-slot:action>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown.items :text="__('Perfil')" :href="route('user.profile')" />
                            <x-dropdown.items :text="__('Sair')"
                                onclick="event.preventDefault(); this.closest('form').submit();" separator />
                        </form>
                    </x-dropdown>
                </x-slot:right>
            </x-layout.header>
        </x-slot:header>
        <x-slot:menu>
            <x-side-bar smart navigate collapsible>
                <x-slot:brand>
                    <div class="flex items-center justify-center  bg-primary-500 w-full m-0 p-1 rounded-r-full mt-1">
                        <img src="{{ asset('/assets/images/brand-logo-transparente-pb.png') }} "
                            class="max-w-[50px] h-auto" />
                        <span
                            x-show="($store['tsui.side-bar'].open &amp;&amp; !$store['tsui.side-bar'].mobile) || $store['tsui.side-bar'].mobile"
                            x-transition="" class="whitespace-nowrap text-mdg font-semibold text-white">BIV
                            Renove</span>
                    </div>
                </x-slot:brand>



                <x-side-bar.item text="Welcome Page" icon="arrow-uturn-left" :route="route('welcome')" />
                <x-side-bar.item text="Cadastros" icon="home" color="secondary">
                    <x-side-bar.item text="Users" icon="user-circle" :route="route('users.index')" />
                    <x-side-bar.item text="Clientes" icon="users" :route="route('clientes.index')" />
                    <x-side-bar.item text="Tags" icon="tag" :route="route('tags.index')" />
                    <x-side-bar.item text="Categorias" icon="bars-3" :route="route('categorias.index')" />
                    <x-side-bar.item text="Produtos" icon="cube" :route="route('produtos.index')" />
                    <x-side-bar.item text="Tabela de preços" icon="table-cells" :route="route('tabelasprecos.index')" />
                </x-side-bar.item>
                <x-side-bar.item text="Vendas" icon="bolt" color="secondary">
                    <x-side-bar.item text="Pedidos de Vendas" icon="shopping-cart" :route="route('pedidosvendas.index')" />
                    <x-side-bar.item text="Tabela de preços" icon="table-cells" :route="route('tabelasprecos.index')" />
                </x-side-bar.item>
                 <x-side-bar.item text="Finaneiro" icon="currency-dollar" color="secondary">
                    <x-side-bar.item text="Tabela de preços" icon="table-cells"  />
                </x-side-bar.item>
                 <x-side-bar.item text="Configurações" icon="cog-6-tooth" color="secondary">
                    <x-side-bar.item text="Tabela de preços" icon="table-cells"  />
                </x-side-bar.item>
                <x-side-bar.item text="Dashboard" color="gray-600" icon="home" :route="route('dashboard')" />

            </x-side-bar>
        </x-slot:menu>
        {{ $slot }}
    </x-layout>
    @livewireScripts
</body>

</html>
