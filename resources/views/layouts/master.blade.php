<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    @yield('title')
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300&display=swap" rel="stylesheet">  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&family=Rubik:ital,wght@0,300;0,400;0,500;0,700;0,800;0,900;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">  <!-- CSS Files -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/now-ui-dashboard.css?v=1.5.0')}}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
  @yield('head')


  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{asset('assets/demo/demo.css')}}" rel="stylesheet" />

</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="yellow">
      <!-- Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"-->
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          TS
        </a>
        <a href="#" class="simple-text logo-normal">
          Taskz.shop
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
      <ul class="nav">
            @if(Auth::check())

                <li class="nav-item">
                    <a class="nav-link " href="/dashboard">
                        <i class="fa-solid fa-gauge"></i>
                        <span class="h5">Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->usertype == "admin")
                <li class="nav-item">
                    <a class="nav-link " href="/roleregiter">
                    <i class="fa-solid fa-users"></i>
                    <span class="h5">User List</span>
                    </a>
                  </li>
                @endif
            @endif
            @if(Auth::user()->usertype == "admin")
            <li class="nav-item">
                <a class="nav-link " href="/tasks">
                <i class="fa-solid fa-list-check"></i>
                <span class="h5">Task List</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/categories">
                <i class="fa-solid fa-list"></i>
                <span class="h5">Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/invoceliste">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="h5">Invoices</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/archiveusers">
                <i class="fa-solid fa-user-xmark"></i>
                <span class="h5">Archive User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/archivetasks">
                <i class="fa-solid fa-box-archive"></i>
                <span class="h5">Archive Task</span>
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link " href="/tasks">
                <i class="fa-solid fa-list-check"></i>
                <span class="h5">My Task</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/myinvoice">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="h5">My Invoice</span>
                </a>
            </li>
            <li class="nav-item fixed-bottom">
                <a class="nav-link " href="/support">
                <i class="fa-solid fa-headset"></i>
                <span class="h5 ">Support</span>
                </a>
            </li>
            @endif

        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>

            <h4 class="" href="#pablo"><strong>Welcome Back, {{Auth::user()->name}} !</strong> </h4>
          </div>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="{{url('user-profile')}}">User Profile</a>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                   </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @if(Auth::user()->usertype == "admin")
                        <a class="dropdown-item" href="/leave-impersonate">Admin</a>
                    @endif
                </div>

              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <!--  Google Maps Plugin    -->
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
  <!-- Chart JS -->
  <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/now-ui-dashboard.min.js?v=1.5.0')}}" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{asset('assets/demo/demo.js')}}"></script>
  @yield('script')
</body>

</html>
