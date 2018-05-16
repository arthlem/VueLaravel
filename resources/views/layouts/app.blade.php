<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ucfirst($title) }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3">
      <a class="navbar-brand" href="/projects">Boite à idées</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
                  
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          @if (Auth::guest())
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">S'inscrire</a>
            </li>
          @else
            @if (isset($route) && $route == 'projects')
              <li class="nav-item">
                <a class="btn btn-success" href="/projects/create"><i class="fa fa-plus"> Ajouter un projet</i></a>
              </li>
            @endif
            @if (isset($route) && $route == 'projects_details')
              <li class="nav-item">
                <a class="btn btn-success" href="/ideas/create/{{$project_id}}"><i class="fa fa-plus"> Ajouter une idée</i></a>
              </li>
            @endif
            <li class="ml-4 nav-item">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{auth()->user()->name}}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Se déconnecter
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li> 
            </li>
          @endif   
        </ul>
      </div>
    </nav>

    <div class="container">
      @yield('content')
    </div>
  </div>
</body>
</html>