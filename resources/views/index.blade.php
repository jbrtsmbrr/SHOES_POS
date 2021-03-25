@php
  // change base on project name to leesen typing each anchor tag
  $url = "/inventory_system";
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventory System</title>
    <link href="{{ asset('plugins/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/css/forms.css') }}" rel="stylesheet" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('plugins/js/font-awesome-all.min.js') }}"></script>

    {{-- TOAST --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/toast/build/toastr.css') }}">
  </head>
  <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <a class="navbar-brand" href="#">COMPANY</a>
      <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
      <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>
      <!-- Navbar-->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="login.html">Logout</a>
          </div>
        </li>
      </ul>
    </nav>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
            <div class="nav">
              {{-- <a class="nav-link" href="index.html">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Dashboard
              </a> --}}
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Masterfiles
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link navlink childnav" url="{{$url}}/dashboard" href="javascript:void(0);">Dashboard</a>
                  <a class="nav-link navlink childnav" url="{{$url}}/product" href="javascript:void(0);">Product</a>
                  <a class="nav-link navlink childnav" url="{{$url}}/warehouse" href="javascript:void(0);">Warehouse</a>
                </nav>
              </div>
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Pages
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                      Authentication
                      <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                      <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="login.html">Login</a>
                          <a class="nav-link" href="register.html">Register</a>
                          <a class="nav-link" href="password.html">Forgot Password</a>
                      </nav>
                  </div>
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                      Error
                      <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                      <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="401.html">401 Page</a>
                          <a class="nav-link" href="404.html">404 Page</a>
                          <a class="nav-link" href="500.html">500 Page</a>
                      </nav>
                  </div>
                </nav>
              </div>
              <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Charts
              </a>
            </div>
          </div>
          <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Cashier
          </div>
        </nav>
      </div>
      <div id="layoutSidenav_content">
        {{-- <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2020</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer> --}}
      </div>
    </div>
  </body>
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> --}}
  <script src="{{ asset('plugins/js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('plugins/toast/toastr.js') }}"></script>
  <script src="{{ asset('plugins/js/scripts.js') }}"></script>
  <script src="{{ asset('plugins/js/bootstrap.bundle.min.js') }}"></script>
  <script type="text/javascript">

    toastr.options.progressBar = true;
    toastr.options.positionClass = "toast-top-left";

    let url = localStorage.getItem("url") ? localStorage.getItem("url") : "dashboard";

    let load_content_div = (url) => {
      fetch(url)
      .then(response => response.text())
      .then(data => {
        // console.log(data);
        $("#layoutSidenav_content").html(data);
      });
    }

    load_content_div(url);

    $(".navlink").on("click", function(e) {
      e.preventDefault();
      let url = $(this).attr('url');
      let childnav = $(this).text();
      localStorage.setItem("url", url);

      document.title = childnav.charAt(0).toUpperCase() + childnav.slice(1);
      
      load_content_div(url);
    });
  </script>
  {{-- <script src="{{ asset('plugins/js/lookup.js') }}"></script> --}}
</html>