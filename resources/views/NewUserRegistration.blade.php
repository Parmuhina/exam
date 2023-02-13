@extends('welcome')

    <!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>New user registration</title>

    @vite(['resources/css/UserRegistration.css', 'resources/js/UserRegistration.js'])

</head>

<body>
@section('content')
    <div class="container">
        <h1> We are appreciate to see our new user</h1>
        <h3> We are one of the most safe and reliable bank in the country.</h3>
        <h3> Our mission is to make safe care of your`s money.</h3>

    </div>

    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'London')">Questionnaire blank</button>
        <button class="tablinks" onclick="openCity(event, 'Paris')">Terms of use</button>
    </div>

    <div id="London" class="tabcontent">
        <h3 style="text-align: center">New user registration</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password for emergency situations')" />

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <label for="password_confirm">Personal identity code:</label><br>
            <input type="password" id="personalCode" name="personalCode"
                   placeholder="111111-11111"><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" placeholder="123@gmail.com"><br>

            <label for="number">Telephone number:</label><br>
            <input type="text" id="number" name="number" placeholder="+37112365478"><br>

            <label for="country">Country where you live:</label><br>
            <input type="text" id="country" name="country" placeholder="Latvia"><br>

            <label for="address">Address where you live:</label><br>
            <input type="text" id="address" name="address"
                   placeholder="Riga, Brīvības iela 3 dz. 23"><br>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Agree that we send to you special orders.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked required>
                <label class="form-check-label" for="flexCheckChecked">
                    Read and agree with use and terms.
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

        </form>
    </div>

    <div id="Paris" class="tabcontent">
        <h3>Terms of use</h3>
        <ul>
            <p style="font-weight: bold; margin: 0; padding: 0">You will need:</p>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                A passport or ID card issued in Latvia with a valid expiration date
            </li>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                Computer and/or mobile phone with a camera
            </li>
        </ul>

        <ul>
            <p style="font-weight: bold; margin: 0; padding: 0">You will need:</p>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                A passport or ID card issued in Latvia with a valid expiration date
            </li>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                Computer and/or mobile phone with a camera
            </li>
        </ul>

        <ul>
            <p style="font-weight: bold; margin: 0; padding: 0">Fee information document:</p>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                The Fee Information Document (FID), which must be provided to prospective clients, and sets out
                pre-contractual fee information for payment account linked services.
            </li>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                List of standardized terms of services most frequently used in the Republic of Latvia and
                their definitions, which lists and defines payment account linked services in a standardized
                manner.
            </li>
        </ul>

        <ul>
            <p style="font-weight: bold; margin: 0; padding: 0">List of standardized terms of services:</p>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                The Fee Information Document (FID), which must be provided to prospective clients, and sets out
                pre-contractual fee information for payment account linked services.
            </li>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                List of standardized terms of services most frequently used in the Republic of Latvia and
                their definitions, which lists and defines payment account linked services in a standardized
                manner.
            </li>
            <li style="list-style-type: none; margin: 10px 0; padding: 0">
                <i class="fa fa-check" style="color: green; margin-right: 10px"></i>
                Statement of Fees (SoF), which must be provided to each client, showing an overview of fees charged
                and interest paid in a year. Statement of Fees will be available in customer Internetbank starting
                from 5 june 2019.
            </li>
        </ul>
    </div>

    <h4>To become new bank user, you need:</h4>

    <ul class="list-ul">
        <li class="list-li">Fill in the questionnaire.</li>
        <li class="list-li">Submit data.</li>
        <li class="list-li">Wait conversation from bank.</li>
        <li class="list-li">Get security codes.</li>
    </ul>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>

</html>

@endsection
