<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buy sell crypto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900">
                    <form method="get" action="{{ route('buySellCrypto') }}">
                        <label for="symbols">Search crypto</label>
                        <input
                            type="text"
                            id="symbols"
                            name="symbols"
                            placeholder="BTC,ETH,..."
                        >
                        <p class="text-red-600">{{$error}}</p>
                        <div class="flex items-center justify-left mt-5">
                            <x-primary-button class="ml-3">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <table class="table-auto w-full text-left mt-5">
                        <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-4 py-2">Crypto</th>
                            <th class="px-4 py-2">Crypto symbol</th>
                            <th class="px-4 py-2">Logo</th>
                            <th class="px-4 py-2">Price in EUR</th>
                            <th class="px-4 py-2">Last hour change</th>
                            <th class="px-4 py-2">Last day change</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cryptoInformation["data"] as $crypto)
                            @foreach($logos as $key=>$logo)
                                @if($crypto->symbol===$key)
                                    <tr class="bg-gray-50-300">
                                        <td class="border px-4 py-2">{{$crypto->name}}</td>
                                        <td class="border px-4 py-2">{{$crypto->symbol}}</td>
                                        <td class="border px-4 py-2"><img src={{$logo}} alt="Logo"></td>
                                        <td class="border px-4 py-2">{{number_format($crypto->quote->{$currency}->price,2)}}</td>
                                        @if($crypto->quote->{$currency}->percent_change_1h>0)
                                            <td class="border px-4 py-2 text-green-600">{{number_format($crypto->quote->{$currency}->percent_change_1h,2)}}</td>
                                        @else
                                            <td class="border px-4 py-2 text-red-600">{{number_format($crypto->quote->{$currency}->percent_change_1h,2)}}</td>

                                        @endif

                                        @if($crypto->quote->{$currency}->percent_change_24h>0)
                                            <td class="border px-4 py-2 text-green-600">{{number_format($crypto->quote->{$currency}->percent_change_24h,2)}}</td>

                                        @else
                                            <td class="border px-4 py-2 text-red-600">{{number_format($crypto->quote->{$currency}->percent_change_24h,2)}}</td>

                                        @endif

                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="py-12 flex">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Buy crypto') }}
                        </h2>
                    </header>


                    <form method="POST" action="{{ route('buyCrypto') }}">
                        @csrf

                        <div class="form-group py-5">
                            <p class="text-red-600">{{$errorBuy}}</p>
                            <label for="accountNumberFrom">From account number</label>
                            <select class="form-select" name="accountNumberFrom" id="accountNumberFrom">
                                @php
                                    $num = 1;
                                @endphp
                                @foreach ($accounts as $account)
                                    @if (strtoupper(substr($account->account_number, 0, 1)) != 'C')
                                        <option value="{{$account->account_number}}">{{ $account->account_number }}/
                                            {{$account->currency_symbol}}
                                            {{number_format($account->currency_amount/100,2)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group py-5">

                            <label for="accountNumberTo">To account number </label>
                            <select class="form-select" name="accountNumberTo" id="accountNumberTo">
                                @php
                                    $num = 1;
                                @endphp
                                @foreach ($accounts as $account)
                                    @if (strtoupper(substr($account->account_number, 0, 1)) == 'C')
                                        <option value="{{$account->account_number}}">{{ $account->account_number }}/
                                            {{$account->crypto_symbol}}
                                            {{number_format($account->crypto_amount/100,2)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-right mt-4">
                            <x-input-label for="amountMoney" :value="__('Amount of crypto')" style="width: 120px"/>
                            <x-text-input id="amountMoney" class="block mt-5 w-full" type="text" style="width: 200px"
                                          name="amountMoney" :value="old('amountMoney')" required autofocus/>
                            <x-input-error :messages="$errors->get('amountMoney')" class="mt-2"/>

                        </div>

                        <div>
                            <div class="flex items-center justify-right">
                                <x-input-label for="securityCode" :value="__('Insert four digit code from your code card.
                            Code number is:')" class="mt-5"/> {{$numberBuy}}</div>
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


        <div class="max-w-lg mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Sell crypto') }}
                        </h2>
                    </header>


                    <form method="POST" action="{{ route('sellCrypto') }}">
                        @csrf

                        <div class="form-group py-5">
                            <p class="text-red-600">{{$errorSell}}</p>
                            <label for="accountNumberFrom">From account number</label>
                            <select class="form-select" name="accountNumberFrom" id="accountNumberFrom">
                                @php
                                    $num = 1;
                                @endphp
                                @foreach ($accounts as $account)
                                    @if (strtoupper(substr($account->account_number, 0, 1)) == 'C')
                                        <option value="{{$account->account_number}}">{{ $account->account_number }}/
                                            {{$account->crypto_symbol}}
                                            {{number_format($account->crypto_amount/100,2)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group py-5">

                            <label for="accountNumberTo">To account number</label>
                            <select class="form-select" name="accountNumberTo" id="accountNumberTo">
                                @php
                                    $num = 1;
                                @endphp
                                @foreach ($accounts as $account)
                                    @if (strtoupper(substr($account->account_number, 0, 1)) != 'C')
                                        <option value="{{$account->account_number}}">{{ $account->account_number }}/
                                            {{$account->currency_symbol}}
                                            {{number_format($account->currency_amount/100,2)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-right mt-4">
                            <x-input-label for="amountMoney" :value="__('Amount of crypto')" style="width: 120px"/>
                            <x-text-input id="amountMoney" class="block mt-5 w-full" type="text" style="width: 200px"
                                          name="amountMoney" :value="old('amountMoney')" required autofocus/>
                            <x-input-error :messages="$errors->get('amountMoney')" class="mt-2"/>

                        </div>


                        <div>
                            <div class="flex items-center justify-right">
                                <x-input-label for="securityCode" :value="__('Insert four digit code from your code card.
                            Code number is:')" class="mt-5"/> {{$numberSell}}</div>
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
