<section>
    <header>
        <h2 class="text-3xl font-bold mb-2">
            {{ __('Update Password') }}
        </h2>

        <p class="text-white/80 text-lg">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-white/80 "/>
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full mr-3  text-[#2F2B40] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-white/80 "/>
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full mr-3  text-[#2F2B40] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-white/80 "/>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full mr-3  text-[#2F2B40] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-bold text-lg py-4 px-8 rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
