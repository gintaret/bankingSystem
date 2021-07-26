<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#!"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
{{--                <li class="nav-item"><a class="nav-link active px-lg-3 py-3 py-lg-4" aria-current="page" href="/">Bank</a></li>--}}

                @if(Auth::check())
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/">Profile</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/search">Search</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/transfer">Transfer Money</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/logout">Logout</a></li>
{{--                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/report">Report</a></li>--}}
                @else
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/register">Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
