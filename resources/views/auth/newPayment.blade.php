<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Send currency') }}
                        </h2>
                    </header>


                    <form method="POST" action="{{ route('newPayment') }}">
                        @csrf

                        <x-input-label for="merchantAccount" :value="__('Merchant account')"/>

                        <div class="form-group py-5">
                            <label for="accountNumber">Account number</label>
                            <select class="form-select" name="accountNumber" id="accountNumber">
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

                        <div>
                            <x-input-label for="sendersName" :value="__('Sender`s name and surname')" class="mt-5"/>
                            <x-text-input id="sendersName" class="block mt-5 w-2/5" type="text"
                                          name="sendersName" :value="old('sendersName')" required autofocus/>
                            <x-input-error :messages="$errors->get('sendersName')" class="mt-2"/>
                        </div>

                        <div>
                            <x-input-label for="sendersAccount" :value="__('Sender`s account number')" class="mt-5"/>
                            <x-text-input id="sendersAccount" class="block mt-5 w-2/5" type="text"
                                          name="sendersAccount" :value="old('sendersAccount')" required autofocus/>
                            <x-input-error :messages="$errors->get('sendersAccount')" class="mt-2"/>
                        </div>

                        <div class="flex items-center justify-right mt-4">
                            <x-input-label for="amountMoney" :value="__('Amount of money')" style="width: 120px"/>
                            <x-text-input id="amountMoney" class="block mt-5 w-full" type="text" style="width: 200px"
                                          name="amountMoney" :value="old('amountMoney')" required autofocus/>
                            <x-input-error :messages="$errors->get('amountMoney')" class="mt-2"/>

                        </div>

                        <div>
                            <div class="flex items-center justify-right">
                                <x-input-label for="securityCode" :value="__('Insert four digit code from your code card.
                            Code number is:')" class="mt-5"/> {{$number}}</div>
                            <x-text-input id="securityCode" class="block mt-5" style="width:100px" type="text"
                                          name="securityCode" :value="old('sendersAccount')" required autofocus/>
                            <x-input-error :messages="$errors->get('securityCode')" class="mt-2"/>
                        </div>

                        <div class="flex items-center justify-left mt-5">
                            <x-primary-button class="ml-3">
                                {{ __('Confirm payment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
