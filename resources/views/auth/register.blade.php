<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-300" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-900 border-gray-700 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-900 border-gray-700 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-900 border-gray-700 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-900 border-gray-700 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4 bg-gray-100 text-gray-900 hover:bg-white">
                        {{ __('REGISTER') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>