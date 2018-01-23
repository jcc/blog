<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>


        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ lang('Articles') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('discussion') }}">{{ lang('Discussions') }}</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- Search Box -->
                <form class="form-inline my-2 my-lg-0 search" role="search" method="get" action="{{ url('search') }}">
                  <input class="form-control mr-sm-2" type="search" name="q" placeholder="{{ lang('Search') }}" required>
                </form>

                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="nav-item"><a class="nav-link" href="{{ url('login') }}">{{ lang('Login') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('register') }}">{{ lang('Register') }}</a></li>
                @else
                    <li class="nav-item notification">
                        <a class="nav-link" href="{{ url('user/notification') }}"><i class="fas fa-bell">
                            <span class="new"
                            @if (Auth::user()->unreadNotifications->count() > 0)
                            style='display: block'
                            @endif
                            >
                            </span>
                        </i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->nickname ?: Auth::user()->name }}
                            <b class="caret"></b>&nbsp;&nbsp;
                            <img class="avatar rounded-circle" src="{{ Auth::user()->avatar }}">
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-item"><a href="{{ url('user', ['name' => Auth::user()->name]) }}"><i class="fas fa-user"></i>{{ lang('Personal Center') }}</a></li>
                            <li class="dropdown-item"><a href="{{ url('setting') }}"><i class="fas fa-cog"></i>{{ lang('Settings') }}</a></li>
                            @if(Auth::user()->is_admin)
                                <li class="dropdown-item"><a href="{{ url('dashboard') }}"><i class="fas fa-tachometer-alt"></i>{{ lang('Dashboard') }}</a></li>
                            @endif
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <a href="{{ url('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>{{ lang('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>