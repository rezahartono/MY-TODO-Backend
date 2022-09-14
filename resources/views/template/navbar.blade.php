    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link">Hi, Welcome Back <strong>{{ $user->name }}</strong></span>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <div class="user-panel d-flex">
                    <a href="#" class="d-block text-gray">
                        <img src="{{ asset('/') }}dist/img/user2-160x160.jpg" class="img-circle border border-dark"
                            alt="Administrator">
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout" role="button">
                    <i class="fas fa-sign-out-alt"></i>
                    Sign Out
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
