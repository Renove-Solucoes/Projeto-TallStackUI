<x-guest-layout>
    <div class="my-6 flex items-center justify-center">
        <img class="max-w-[50px]" src="{{ asset('/assets/images/fav-icon.png') }}" />
        <span class="whitespace-nowrap text-2xl font-bold text-sky-900">BIV Renove</span>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-4">
            <x-input label="Email *" type="email" name="email" :value="old('email', 'test@example.com')" required autofocus autocomplete="username" />

            <x-password label="Password *" type="password" name="password" required autocomplete="current-password" />
        </div>

        <div class="block mt-4">
            <x-checkbox label="Remember me" id="remember_me" type="checkbox" name="remember" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('register') }}">
                    {{ __('Sign up') }}
                </a>
            @endif

            <x-button type="submit" class="ms-3">
                {{ __('Log in') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
