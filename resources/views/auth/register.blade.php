<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="hidden" name="role" value="{{ request('role', 'student') }}">

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        @if(request('role') !== 'teacher')
            <div class="mt-4 p-4 bg-gray-50 rounded border border-gray-200">
                <x-input-label value="{{ __('Select Your English Level') }}" class="mb-2" />
                <div class="grid grid-cols-2 gap-2">
                    <label class="inline-flex items-center"><input type="checkbox" name="level[]" value="A0" class="rounded border-gray-300 text-gray-900 shadow-sm"><span class="ml-2 text-sm text-gray-600">A0 (Beginner)</span></label>
                    <label class="inline-flex items-center"><input type="checkbox" name="level[]" value="A1" class="rounded border-gray-300 text-gray-900 shadow-sm"><span class="ml-2 text-sm text-gray-600">A1 (Elementary)</span></label>
                    <label class="inline-flex items-center"><input type="checkbox" name="level[]" value="A2" class="rounded border-gray-300 text-gray-900 shadow-sm"><span class="ml-2 text-sm text-gray-600">A2 (Pre-Intermediate)</span></label>
                    <label class="inline-flex items-center"><input type="checkbox" name="level[]" value="B1" class="rounded border-gray-300 text-gray-900 shadow-sm"><span class="ml-2 text-sm text-gray-600">B1 (Intermediate)</span></label>
                </div>
                <x-input-error :messages="$errors->get('level')" class="mt-2" />
            </div>
        @else
            <div class="mt-4 p-4 bg-gray-900 text-white rounded text-center text-sm font-bold">
                 Creating Teacher Account
            </div>
        @endif

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
