<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New crypto account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('New crypto account') }}
                        </h2>
                    </header>


                    <form method="POST" action="{{ route('newCryptoAccount') }}">
                        @csrf

                        <div>
                            <x-input-label for="merchantAccount" :value="__('To create new account for cryptocurrency
                        please fill security code and press button submit.')" />

                        </div>

                        <div>
                            <div class="flex items-center justify-right">
                                <x-input-label for="securityCode" :value="__('Insert four digit code from your code card.
                            Code number is:')" class="mt-5" /> {{$number}}</div>
                            <x-text-input id="securityCode" class="block mt-5 w-full" type="text" style="width: 100px"
                                          name="securityCode" :value="old('securityCode')" autofocus />
                            <x-input-error :messages="$errors->get('securityCode')" class="mt-2" />

                        </div>
                        <p class="text-red-600">{{$error}}</p>
                        <div class="flex items-center justify-end mt-5">
                            <x-primary-button class="ml-3">
                                {{ __('Confirm create new account') }}
                            </x-primary-button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
