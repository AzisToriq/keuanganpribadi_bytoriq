<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            {{ __('Permanently delete your account.') }}
        </p>
    </div>

    <div class="px-4 py-5 sm:p-6">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <button
                type="button"
                wire:click="confirmUserDeletion"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-25 transition"
            >
                {{ __('Delete Account') }}
            </button>
        </div>

        <!-- Modal Konfirmasi Penghapusan -->
        @if($confirmingUserDeletion)
            <div class="fixed z-10 inset-0 overflow-y-auto" wire:ignore.self>
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('Delete Account') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>
                                <div class="mt-4">
                                    <input type="password"
                                        class="mt-1 block w-3/4 rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        autocomplete="current-password"
                                        placeholder="{{ __('Password') }}"
                                        wire:model="password"
                                        wire:keydown.enter="deleteUser"
                                        x-ref="password"
                                    />
                                    @error('password')
                                        <span class="text-sm text-red-600 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button"
                                wire:click="deleteUser"
                                wire:loading.attr="disabled"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                {{ __('Delete Account') }}
                            </button>
                            <button type="button"
                                wire:click="$toggle('confirmingUserDeletion')"
                                wire:loading.attr="disabled"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                            >
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
