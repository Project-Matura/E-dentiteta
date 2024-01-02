    <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                @if (Auth::user() && Auth::user()->role == 'ADM')
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">Admin</li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.profile') }}">Moj profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.organisations') }}">Organizacije</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.cards') }}">Kartice</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}">Odjava</a>
                            </li>
                        </ul>
                    </div>
                @elseif(Auth::user() && Auth::user()->role == 'ORG')
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">Organisation</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('organisation.profile') }}">Moj profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Odjava</a>
                        </li>
                    </ul>
                </div>
                @elseif(Auth::user() && Auth::user()->role == 'USR')
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">User</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.profile') }}">Moj profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Odjava</a>
                        </li>
                    </ul>
                </div>
                @else
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registracija</a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </nav>
    </div>
