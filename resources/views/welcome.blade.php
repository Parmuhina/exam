<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>
    @vite(['resources/css/welcome.css'])

</head>
<body>
<header class="header">
    <div class="row" style="background:#058135; display: flex; flex-direction: row; justify-content: space-between;">
        <a href="/start">
            <div>
                <img class="logo" src="Photo/SafeBank2.jpg" alt="Logo not found" title="Dashboard">
            </div>
        </a>

        <div class="two-buttoms">
            <ul>
                <li><a href="/register">Reģistrēt lietotāju &#9997;</a></li>
                <li><a href="/login">Pieslēgties &#8626; </a></li>
            </ul>
        </div>
    </div>


    <div class="row" style="background:#058135; display: flex">
        <div class="menu-bar ">
            <ul>
                <li class="active"><a href="/login">Maksājumi</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="/login">Jauns maksājums</a></li>
                            <li><a href="/login">Maksājumu vēsture</a></li>
                        </ul>
                    </div>
                </li>
                <li class="active"><a href="/login">Konti</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="/login">Jauns maksājums</a></li>
                            <li><a href="/login">Maksājumu vēsture</a></li>
                        </ul>
                    </div>
                </li>
                <li class="active"><a href="/login">Kriptovalūta</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="/login">Kriptovalūtas markets</a></li>
                            <li><a href="/login">Kriptovalūtas transakciju pārskats</a></li>
                        </ul>
                    </div>
                </li>


            </ul>
        </div>
    </div>
</header>
@yield('content')

</body>



</html>


