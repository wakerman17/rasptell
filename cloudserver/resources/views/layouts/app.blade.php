<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rasptell') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
              @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Rasptell') }}
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Rasptells kontrollcenter') }}
                </a>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Logga in') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Registrera') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('newRasp') }}">
                                        {{ __('Ny rasp') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logga ut') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".lightOn").click(function() {
				var id = $(this).attr('id');
				var id_residence = document.getElementById(id).value;
				var ip = document.getElementById('ip-address').value;
				$.ajax({
					type: "GET",
					//headers: {  'Access-Control-Allow-Origin': * }
					url: "https://cors-anywhere.herokuapp.com/" + "http://" + ip + "/indexOn.php",
					data: "id=" + id_residence,
					success: "success",
					timeout: 4000,
					error: function(xhr, textStatus, errorThrown){
						alert('on request failed');
					},
				});
				var idn = parseInt(id);
				$("#" + (idn).toString()).attr('disabled', 'disabled');
				$("#" + (idn+1).toString()).removeAttr('disabled');
            });
            $(".lightOff").click(function() {
				var id = $(this).attr('id');
				var id_residence = document.getElementById(id).value;
				var ip = document.getElementById('ip-address').value;
				$.ajax({
					type: "GET",
					url: "https://cors-anywhere.herokuapp.com/" + "http://" + ip + "/indexOff.php",
					data: "id=" + id_residence,
					success: "success",
					timeout: 4000,
					error: function(xhr, textStatus, errorThrown){
						alert('off request failed');
					},
				});
				var idn = parseInt(id);
				$("#" + (idn).toString()).attr('disabled', 'disabled');
				$("#" + (idn-1).toString()).removeAttr('disabled');
            });
        });
    </script>
</body>
</html>
