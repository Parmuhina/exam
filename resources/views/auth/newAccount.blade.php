<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('New account') }}
                        </h2>
                        <h2 class="text-lg font-medium text-red-900">
                            {{ $error}}
                        </h2>
                    </header>


                    <form method="POST" action="{{ route('newAccount') }}">
                        @csrf

                        <div>
                            <x-input-label for="merchantAccount" :value="__('If you want to edit money for new account
                            from existing account choose account number, if not please choose that you won`t.
                            Please fill data above. Compulsory insert
                            currency symbol of your account. If area will be empty,
                            new account currency will be EUR.')" />

                            <div class="form-group py-5">
                                <label for="accountNumber">Account number</label>
                                <select class="form-control" id="accountNumber">
                                    <option value="">Don`t want to select account number</option>
                                    @php
                                        $num = 1;
                                    @endphp
                                    @foreach ($accounts as $account)
                                        @if (strtoupper(substr($account->account_number, 0, 1)) != 'C')
                                            <option value="{{$account->account_number}}">{{ $account->account_number }}
                                                /{{$account->currency_symbol}}
                                                {{number_format($account->currency_amount/100,2)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="flex items-center justify-right mt-4">
                            <x-input-label for="amountMoney" :value="__('Amount of money')" style="width: 120px"/>
                            <x-text-input id="amountMoney" class="block mt-5 w-full" type="text" style="width: 200px"
                                          name="amountMoney" :value="old('amountMoney')" autofocus />
                            <x-input-error :messages="$errors->get('amountMoney')" class="mt-2" />

                            <x-input-label for="currencySymbol" :value="__('Currency symbol')" style="width: 120px"
                                           class="ml-10"/>
                            <x-text-input id="currencySymbol" class="block mt-5 w-full" type="text" style="width: 100px"
                                          name="currencySymbol" :value="old('currencySymbol')" autofocus />
                            <x-input-error :messages="$errors->get('currencySymbol')" class="mt-2" />
                        </div>

                        <div>
                            <div class="flex items-center justify-right">
                                <x-input-label for="securityCode" :value="__('Insert four digit code from your code card.
                            Code number is:')" class="mt-5" /> <p>{{$number}}</p></div>
                            <x-text-input id="securityCode" class="block mt-5 w-full" type="text" style="width: 100px"
                                          name="securityCode" :value="old('securityCode')" autofocus />
                            <x-input-error :messages="$errors->get('securityCode')" class="mt-2" />
                        </div>

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
