<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions history') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Currency transactions history') }}
                        </h2>
                    </header>

                    <form method="POST" action="{{ route('currencyFilter') }}">
                        @csrf

                        <div class="flex py-5">
                            <div class="mr-5">
                                <label for="accountNumber">Account number</label>
                                <select class="form-select" name="accountNumber" id="accountNumber">

                                    @foreach ($accounts as $account)
                                        @if (strtoupper(substr($account->account_number, 0, 1)) != 'C')
                                            <option value="{{$account->account_number}}">{{ $account->account_number }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="sendersName" >Sender`s name and surname </label>
                                <input id="sendersName"  type="text"
                                              name="sendersName"  />

                            </div>

                            <div class="ml-5">
                                <label for="date-picker-from">Date from:</label>
                                <input type="date" id="date-picker-from" name="selected_date_from">
                            </div>
                            <div class="display:inline-block">
                                <label for="date-picker-to">Date to:</label>
                                <input type="date" id="date-picker-to" name="selected_date_to">
                            </div>
                            <p class="text-red-600">{{$error}}</p>
                        </div>
                        <button
                            class="bg-white text-black font-medium py-2 px-4 rounded-lg border border-gray-500 hover:shadow-lg">
                            Submit
                        </button>


                    </form>

                    <table class="table-auto w-full text-left mt-5">
                        <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-4 py-2">From/To</th>
                            <th class="px-4 py-2">Currency symbol</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Senders name</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $result)
                            @if($result->from_account===$filterAccount)
                                <tr class="bg-red-300">
                                    <td class="border px-4 py-2">{{$result->to_account}}</td>
                                    <td class="border px-4 py-2">{{$result->symbol}}</td>
                                    <td class="border px-4 py-2">-{{number_format($result->amount/100,2)}}</td>
                                    <td class="border px-4 py-2">{{$result->senders_name}}</td>
                                    <td class="border px-4 py-2">{{$result->created_at}}</td>
                                </tr>
                            @endif
                            @if($result->to_account===$filterAccount)
                                <tr class="bg-emerald-200">
                                    <td class="border px-4 py-2">{{$result->from_account}}</td>
                                    <td class="border px-4 py-2">{{$result->symbol}}</td>
                                    <td class="border px-4 py-2">{{number_format($result->amount/100,2)}}</td>
                                    <td class="border px-4 py-2">{{$result->senders_name}}</td>
                                    <td class="border px-4 py-2">{{$result->created_at}}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>
