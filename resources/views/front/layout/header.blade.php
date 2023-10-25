<header class="navigation bg-tertiary">
    <nav class="navbar navbar-expand-xl navbar-light text-center py-3">
        <div class="container">
            <a class="navbar-brand" href="{{route('home')}}">
                <img style="width: 50px; margin: 0 10px 0 0;" loading="prelaod" decoding="async" class="img-fluid" width="160"
                    src="{{ asset('asset/logo/logo.png') }}" alt="Issue Tracker">Issue Tracker
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"> <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item "> <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item "> <a class="nav-link" href="how-it-works.html">How It Works</a>
                    </li>
                    <li class="nav-item "> <a class="nav-link" href="services.html">Services</a>
                    </li>
                    <li class="nav-item "> <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    {{-- <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item " href="blog.html">Blog</a>
                            </li>
                            <li><a class="dropdown-item " href="blog-details.html">Blog Details</a>
                            </li>
                            <li><a class="dropdown-item " href="service-details.html">Service Details</a>
                            </li>
                            <li><a class="dropdown-item " href="faq.html">FAQ&#39;s</a>
                            </li>
                            <li><a class="dropdown-item " href="legal.html">Legal</a>
                            </li>
                            <li><a class="dropdown-item " href="terms.html">Terms &amp; Condition</a>
                            </li>
                            <li><a class="dropdown-item " href="privacy-policy.html">Privacy &amp; Policy</a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
                <!-- account btn -->
                @if (!auth()->user())
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Log In</a>
                @endif
                <a href="{{ route('hr.register.create') }}" class="btn btn-primary ms-2 ms-lg-3">Sign Up</a>
            </div>
        </div>
    </nav>
</header>
