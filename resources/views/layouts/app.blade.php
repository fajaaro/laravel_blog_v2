<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/9dec657e70.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        setInterval(function() {
            let day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        

            let time = new Date(),
                formatTime = `${day[time.getDay()]}, ${time.getDate()} ${month[time.getMonth()]} ${time.getFullYear()} ${time.getHours()}:${time.getMinutes()}:${time.getSeconds()}`;

            $('.time').html(formatTime);

        }, 1000);
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700|Montserrat:300,400,500,700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="https://icons.iconarchive.com/icons/iconexpo/speech-balloon-green/256/speech-balloon-green-b-icon.png">
</head>
<body>
        
    <div id="loading">
        <img id="loading-image" src="{{ url('img/loading.gif') }}">
    </div>

    <main>
        @yield('content')
    </main>
        
    <div class="row">
        <div class="col-3">
            <div class="left-sidebar">
                <div class="avatar-box">
                    @if (Cache::has('userActive') && Cache::get('userActive')->image()->exists())
                        <img src="{{ 'http://localhost:8000/storage/' . Cache::get('userActive')->image->path }}" class="avatar">       
                    @else
                        <img src="{{ asset('img/avatar.svg') }}" class="avatar">                                            
                    @endif
                </div>

                <div class="user-info-box mt-4">
                    <h5 class="user-name">{{ Cache::get('userActive')->name ?? 'Guest' }}</h5>
                    <span class="user-status">Student</span>
                </div>

                <div class="main-menu-box">
                    <ul>
                        <li class="nav-item nav-heading">Main Menu</li>
                        @if (Cache::has('userActive'))
                            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link-menu active">Home</a></li>
                            <li class="nav-item"><a href="{{ route('post.myPosts') }}" class="nav-link-menu my-posts-link">My Posts</a></li>
                            <li class="nav-item"><a href="{{ route('post.create') }}" class="nav-link-menu">Create Post</a></li>
                            <li class="nav-item">Update Post</li>
                            <li class="nav-item">Delete Post</li>
                            <li class="nav-item"><a href="{{ route('post.myTrashedPosts') }}" class="nav-link-menu">Trash</a></li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link-menu">Login</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link-menu">Register</a></li>
                        @endif
                    </ul>
                </div>

                @if (Cache::has('userActive'))
                    <div class="my-account-box">
                        <ul>
                            <li class="nav-item nav-heading">My Account</li>
                            <li class="nav-item"><a href="{{ route('user.edit', ['user' => Cache::get('userActive')->id] ) }}" class="nav-link-menu">Edit Profile</a></li>
                            <li class="nav-item">Security Password</li>
                            <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link-menu nav-logout">Logout</a></li>

                            <form action="{{ route('logout') }}" method="post" class="logout-form">
                                @csrf
                            </form>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-9 right-sidebar">
            <div class="heading mb-4">
                <span class="heading-title"><a href="{{ route('home') }}" class="title-link">{{ config('app.name', 'Fajar\'s Blog') }}</a></span>
                <small class="float-right time">Time</small>
            </div>

            @if (session('loginSuccess'))
                <script>
                    swal("Login Success", "You are logged in!", "success");
                </script>
            @endif

            @if (session('logoutSuccess'))
                <script>
                    swal("Logout Success", "You are logged out!", "success");
                </script>
            @endif

            @if (session('verified') || session('status'))
                <div class="row mb-5">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-header">Dashboard</div>

                            <div class="card-body">
                                @if (session('verified'))
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active bg-success"><i class="fas fa-check mr-2"></i>Register Success!</li>
                                        <li class="list-group-item text-dark">Thank you for register and verifying your email address.</li>
                                    </ul>
                                @endif

                                @if (session('status'))
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active bg-success"><i class="fas fa-check mr-2"></i>Reset Password Success!</li>
                                        <li class="list-group-item">{{ session()->get('status') }}</li>
                                    </ul>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @yield('right-sidebar')   
        </div>
    </div>


    {{-- </div> --}}

{{--     <div class="social-btns">
        <a class="btn instagram btn-social-media" href="#"><i class="fa fa-instagram"></i></a>
        <a class="btn facebook btn-social-media" href="#"><i class="fa fa-facebook"></i></a>
        <a class="btn twitter btn-social-media" href="#"><i class="fa fa-twitter"></i></a>
        <a class="btn youtube btn-social-media" href="#"><i class="fa fa-youtube"></i></a>
        <a class="btn google btn-social-media" href="#"><i class="fa fa-google"></i></a>
        <a class="btn github btn-social-media" href="#"><i class="fa fa-github"></i></a>
        <a class="btn linkedin btn-social-media" href="#"><i class="fa fa-linkedin"></i></a>
    </div> --}}
    
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
