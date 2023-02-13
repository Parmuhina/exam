<x-app-layout>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex">
                <div class="hidden space-x-8 sm:-my-px sm:ml-2 sm:flex">
                    <x-nav-link :href="route('codes')" :active="request()->routeIs('codes')">
                        {{ __('Your code card') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex py-5">
        <div class="mx-20" style="width: 250px; text-align: center">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h5 class="mb-2"><b>Four digit code:</b></h5>
                    <ol>
                        @php
                            $num = 1;
                        @endphp
                    @foreach($codesFour as $code)
                            <li><b>{{$num.". "}}</b>{{$code}}</li>
                            @php
                                $num++;
                            @endphp
                    @endforeach
                    </ol>
                </div>
            </div>
        </div>



    </div>

</x-app-layout>


