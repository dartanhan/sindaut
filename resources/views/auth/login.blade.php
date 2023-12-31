<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('admin.login.do') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>
            <div class="mt-4">
                <div class="g-recaptcha" data-sitekey="{{ env('DATA_SITE_KEY') }}"></div>
            </div>
            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="ml-4">
                    {{ __('Efetuar Login') }}
                </x-jet-button>
            </div>
            @if(session('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif
        </form>
    </x-jet-authentication-card>
</x-app-layout>

