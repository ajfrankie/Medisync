    <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
        <div class="container">
            <a class="navbar-logo" href="/">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="19"
                    class="logo logo-dark">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="19"
                    class="logo logo-light">
            </a>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav ms-auto" id="topnav-menu">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about-us') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#roadmap">Roadmap</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#news">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faqs">FAQs</a>
                    </li>

                </ul>

                <div class="my-2 ms-lg-2">
                    <a href="#" class="btn btn-outline-success w-xs">Sign in</a>
                </div>
            </div>
        </div>
    </nav>