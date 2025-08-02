<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Browser Sessions') }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            {{ __('Manage and log out your active sessions on other browsers and devices.') }}
        </p>
    </div>

    <div class="px-4 py-5 sm:p-6">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-6">
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <!-- Desktop Icon -->
                                <svg class="size-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25" />
                                </svg>
                            @else
                                <!-- Mobile Icon -->
                                <svg class="size-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <div class="ms-3">
                            <div class="text-sm text-gray-600">
                                {{ $session->agent->platform() ?? __('Unknown') }} - {{ $session->agent->browser() ?? __('Unknown') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center mt-5">
            <button wire:click="confirmLogout" wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                {{ __('Log Out Other Browser Sessions') }}
            </button>

            <span class="ms-3 text-sm text-green-600" wire:loading.remove wire:target="logoutOtherBrowserSessions">
                @if (session()->has('loggedOut'))
                    {{ __('Done.') }}
                @endif
            </span>
        </div>

        <!-- Modal Konfirmasi Logout -->
        @if ($confirmingLogout)
            <div class="fixed z-10 inset-0 overflow-y-auto" wire:ignore.self>
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __('Log Out Other Browser Sessions') }}
                            </h3>

                            <div class="mt-2 text-sm text-gray-500">
                                {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}
                            </div>

                            <div class="mt-4">
                                <input type="password"
                                    class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    wire:model="password"
                                    wire:keydown.enter="logoutOtherBrowserSessions"
                                    autocomplete="current-password"
                                    placeholder="{{ __('Password') }}"
                                    x-ref="password" />
                                @error('password')
                                    <span class="text-sm text-red-600 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled"
                                class="inline-flex justify-center w-full sm:w-auto px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Log Out Other Browser Sessions') }}
                            </button>

                            <button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled"
                                class="mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto inline-flex justify-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
