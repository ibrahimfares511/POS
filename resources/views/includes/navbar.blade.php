<nav class="navbar sticky-top bg-light navbar-default m-0 p-0 shadow-sm">
    <!-- Brand and toggle get grouped for better mobile display -->
    <nav class="navbar navbar-light flex-grow-1">
      <div class="container">
        <div class="navbar-brand">
          <div class="date-time">
              <span class='time'></span>
              <span class='date'></span>
          </div>
        </div>
        <div>
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto"></ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
              @endif
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
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
    <div class="navbar-header fixed-brand hide">
        <button type="button" class="navbar-toggle d-none d-md-block"  id="menu-toggle-2">
          <i class="fas fa-bars fa-lg"></i>
        </button>
        <button class="navbar-toggle d-block d-md-none" id="menu-toggle">
          <i class="fas fa-bars fa-lg"></i>
        </button>
        <a class="navbar-brand" href="{{ Route('home') }}"><img style="width: 50px" src="{{ URL('pos_style/images/route.jfif') }}" alt="Route"></a>
    </div>
  </nav>
