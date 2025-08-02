<form wire:submit.prevent="updateProfileInformation" class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-900">
        {{ __('Profile Information') }}
    </h2>
    <p class="text-sm text-gray-600 mt-1">
        {{ __('Update your account\'s profile information and email address.') }}
    </p>

    <div class="grid grid-cols-6 gap-6 mt-6">
        {{-- Profile Photo --}}
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <label for="photo" class="block text-sm font-medium text-gray-700">
                    {{ __('Photo') }}
                </label>

                <!-- Input File Hidden -->
                <input type="file" id="photo" class="hidden"
                    wire:model.live="photo"
                    x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    " />

                <!-- Current Photo -->
                <div class="mt-2" x-show="!photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}"
                        alt="{{ $this->user->name }}"
                        class="rounded-full size-20 object-cover">
                </div>

                <!-- Preview New Photo -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <!-- Select & Remove Buttons -->
                <div class="mt-2 flex gap-2">
                    <button type="button"
                        class="inline-flex items-center px-3 py-1.5 bg-gray-100 border border-gray-300 rounded-md text-sm hover:bg-gray-200"
                        x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button"
                            wire:click="deleteProfilePhoto"
                            class="inline-flex items-center px-3 py-1.5 bg-red-100 border border-red-300 text-red-700 rounded-md text-sm hover:bg-red-200">
                            {{ __('Remove Photo') }}
                        </button>
                    @endif
                </div>

                @error('photo')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- Name --}}
        <div class="col-span-6 sm:col-span-4">
            <label for="name" class="block text-sm font-medium text-gray-700">
                {{ __('Name') }}
            </label>
            <input id="name" type="text" required autocomplete="name"
                wire:model.defer="state.name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            @error('state.name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="col-span-6 sm:col-span-4">
            <label for="email" class="block text-sm font-medium text-gray-700">
                {{ __('Email') }}
            </label>
            <input id="email" type="email" required autocomplete="username"
                wire:model.defer="state.email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            @error('state.email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            {{-- Email verification --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-gray-600">
                    {{ __('Your email address is unverified.') }}
                    <button type="button"
                        wire:click.prevent="sendEmailVerification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-6 flex items-center justify-end">
        <div wire:loading.remove wire:target="photo,updateProfileInformation" class="me-4 text-green-600">
            @if (session()->has('flash.banner'))
                {{ __('Saved.') }}
            @endif
        </div>
        <button type="submit"
            wire:loading.attr="disabled"
            wire:target="photo"
            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition ease-in-out duration-150">
            {{ __('Save') }}
        </button>
    </div>
</form>
