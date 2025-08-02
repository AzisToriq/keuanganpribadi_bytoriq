<form wire:submit.prevent="updatePassword" class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-900">
        {{ __('Update Password') }}
    </h2>
    <p class="text-sm text-gray-600 mt-1">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <div class="grid grid-cols-6 gap-6 mt-6">
        <!-- Current Password -->
        <div class="col-span-6 sm:col-span-4">
            <label for="current_password" class="block text-sm font-medium text-gray-700">
                {{ __('Current Password') }}
            </label>
            <input id="current_password" type="password" autocomplete="current-password"
                wire:model.defer="state.current_password"
                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            @error('state.current_password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div class="col-span-6 sm:col-span-4">
            <label for="password" class="block text-sm font-medium text-gray-700">
                {{ __('New Password') }}
            </label>
            <input id="password" type="password" autocomplete="new-password"
                wire:model.defer="state.password"
                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            @error('state.password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="col-span-6 sm:col-span-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation" type="password" autocomplete="new-password"
                wire:model.defer="state.password_confirmation"
                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            @error('state.password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end">
        <div wire:loading.remove wire:target="updatePassword" class="text-green-600 me-4">
            @if (session()->has('flash.banner'))
                {{ __('Saved.') }}
            @endif
        </div>
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition ease-in-out duration-150">
            {{ __('Save') }}
        </button>
    </div>
</form>
