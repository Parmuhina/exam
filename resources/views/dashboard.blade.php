<x-app-layout>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex">
                <div class="hidden space-x-8 sm:-my-px sm:ml-2 sm:flex">
                    <h1 style="font-size: x-large" class="hidden space-x-8 sm:-my-px sm:ml-2 sm:flex">
                        &#127974
                    </h1>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-2 sm:flex">
                    <x-nav-link :href="route('newAccount')" :active="request()->routeIs('newAccount')">
                        {{ __('New account') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-2 sm:flex">
                    <x-nav-link :href="route('codes')" :active="request()->routeIs('codes')">
                        {{ __('Your code card') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </nav>

    @php
        $num = 1;
    @endphp
    @foreach($accounts as $account)

        <div class="py-3">
            <div class="max-w-sm mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="card-body">
                            <h5 class="card-title"><b>{{$num.". "}}</b>{{ $account->account_number }}</h5>
                            <p class="card-text "></p>
                            <div class="card-footer text-muted">

                                @if (strtoupper(substr($account->account_number, 0, 1)) == 'C')
                                    {{ $account->crypto_symbol}} / {{number_format($account->crypto_amount/100,2)}}

                                @else
                                    {{ $account->currency_symbol}} / {{number_format($account->currency_amount/100,2)}}
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $num ++;
        @endphp
    @endforeach


</x-app-layout>

