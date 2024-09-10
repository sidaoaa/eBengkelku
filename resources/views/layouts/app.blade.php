@php
  // Get the first segment of the URL
  $page = Request::segment(1);

  // Check if the session has 'id_pelanggan'
  if (Session::has('id_pelanggan')) {
      $existing = DB::table('t_order_online')
          ->where('id_customer', Session::get('id_pelanggan'))
          ->where('status_order', 'TEMP')
          ->first();

      $getItem = $existing
          ? DB::table('t_order_item_online')
              ->where('id_order_online', $existing->id)
              ->count()
          : 0;
  }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
  <!--====== Title ======-->
  <title>@yield('title')</title>
  <link rel="apple-touch-icon" sizes="76x76" href="<?= url('logos/icon.png') ?>">
  <!--====== Bootstrap css ======-->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!--====== Line Icons css ======-->
  <link rel="stylesheet" href="{{ asset('css/LineIcons.css') }}">
  <!--====== Magnific Popup css ======-->
  <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
  <!--====== Default css ======-->
  <link rel="stylesheet" href="{{ asset('css/default.css') }}">
  <!--====== Font Awesome (menggantikan Boxicons) ======-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <!--====== boxicon css ======-->
  {{-- <link rel="stylesheet" href="<?= url('boxicons/css/boxicons.min.css') ?>"> --}}
  <!--====== owlcarousel css ======-->
  <link rel="stylesheet" href="<?= url('owl-carousel/dist/assets') ?>/owl.carousel.min.css">
  <link rel="stylesheet" href="<?= url('owl-carousel/dist/assets') ?>/owl.theme.default.min.css">
  <!--====== Selectize css ======-->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous">
  <!--====== Style css ======-->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!--====== DataTables css ======-->
  <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css') }}">
  <!--====== Custom css ======-->
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
  <!-- Loader -->
  <div id="loader">
    <div id="center">
      <center>
        <img src="<?= url('logos/loader.gif') ?>" style="width: 170px;">
        <p class="text-info">Sedang memproses ...</p>
      </center>
    </div>
  </div>
  <!-- JavaScript Section -->
  @yield('script')
  <!--====== HEADER PART START ======-->
  <header class="header-area">
    <div class="navgition navgition-transparent">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg">
              <a class="navbar-brand" href="<?= route('home') ?>">
                <img src="<?= url('logos/logo_side.png') ?>" alt="eBengkelku - Logo" style="width: 150px;">
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarOne"
                aria-controls="navbarOne" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse sub-menu-bar" id="navbarOne">
                <ul class="navbar-nav m-auto">
                  <li class="nav-item <?= $page == '' ? 'active' : '' ?>">
                    <a href="<?= route('home') ?>">
                      <i class='fa-solid fa-house-chimney'></i> Home
                    </a>
                  </li>
                  <li class="nav-item <?= $page == 'event' ? 'active' : '' ?>">
                    <a href="<?= route('event') ?>">
                      <i class='fa-regular fa-calendar'></i> Event
                    </a>
                  </li>
                  <li class="nav-item <?= $page == 'workshop' ? 'active' : '' ?>">
                    <a href="<?= route('workshop') ?>">
                      <i class='fa-solid fa-city sm'></i> Workshop
                    </a>
                  </li>
                  <li class="nav-item <?= $page == 'product' ? 'active' : '' ?>">
                    <a href="<?= route('product') ?>">
                      <i class='fa-solid fa-boxes-stacked '></i> Product & Spare Parts
                    </a>
                  </li>
                  <li class="nav-item <?= $page == 'used_car' ? 'active' : '' ?>">
                    <a href="<?= route('used_car') ?>">
                      <i class='fa-solid fa-car-side sm'></i> Used Car
                    </a>
                  </li>
                  <?php if(Session::has('id_pelanggan')){ ?>
                  <li class="nav-item <?= $page == 'profile' ? 'active' : '' ?>">
                    <a href="{{ route('profile', ['visit' => '', 'page' => 'profile']) }}">
                      <i class='fa-solid fa-user sm'></i> Profile
                    </a>
                  </li>
                  <?php }else{ ?>
                  <li class="nav-item <?= $page == 'login' ? 'active' : '' ?>">
                    <a href="<?= route('login') ?>">
                      <i class='fa-solid fa-door-open sm'></i> Login
                    </a>
                  </li>
                  <?php } ?>
                  <li class="nav-item <?= $page == 'cart' ? 'active' : '' ?>">
                    <a href="<?= route('cart') ?>">
                      <i class='fa-solid fa-cart-shopping sm'></i>
                      <span class="badge badge-pill badge-danger" id="countCart">
                        0
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
            </nav> <!-- navbar -->
          </div>
        </div> <!-- row -->
      </div> <!-- container -->
    </div> <!-- navgition -->
  </header>
  @yield('content')

  <!--====== FOOTER PART START ======-->

  <footer id="footer" class="footer-area">
    <div class="footer-widget">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="footer-link">
              <h6 class="footer-title">Company</h6>
              <ul>
                <li><a href="javascript:;">About</a></li>
                <li><a href="javascript:;">Contact</a></li>
                <li><a href="javascript:;">Career</a></li>
              </ul>
            </div> <!-- footer link -->
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="footer-link">
              <h6 class="footer-title">Product & Services</h6>
              <ul>
                <li><a href="javascript:;">Products</a></li>
                <li><a href="javascript:;">Business</a></li>
                <li><a href="javascript:;">Developer</a></li>
              </ul>
            </div> <!-- footer link -->
          </div>
          <div class="col-lg-3 col-md-4 col-sm-5">
            <div class="footer-link">
              <h6 class="footer-title">Help & Support</h6>
              <ul>
                <li><a href="javascript:;">Support Center</a></li>
                <li><a href="javascript:;">FAQ</a></li>
                <li><a href="javascript:;">Terms & Conditions</a></li>
              </ul>
            </div> <!-- footer link -->
          </div>
          <div class="col-lg-4 col-md-6 col-sm-7">
            <div class="footer-link">
              <h6 class="footer-title">Our Social Media</h6>
              <ul>
                <li><a href="javascript:;"><i class="fab fa-facebook-square"></i> Facebook</a></li>
                <li><a href="javascript:;"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="javascript:;"><i class="fab fa-twitter"></i> Twitter</a></li>
                <li><a href="javascript:;"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                <li><a href="{{ route('info') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                      <path
                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                    </svg> Info
                  </a></li>
              </ul>
            </div> <!-- footer newsletter -->
          </div>
        </div> <!-- row -->
      </div> <!-- container -->
    </div> <!-- footer widget -->
    <div class="footer-copyright">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="copyright text-center">
              <p class="text">
                Copyright &copy; {{ now()->year }} eBengkelku - Service, Spare Part & Smart Tools
                Powered By <a href="https://cnplus.id/" target="_blank" class="text-success">CNPLUS</a>
              </p>
            </div>
          </div>
        </div> <!-- row -->
      </div> <!-- container -->
    </div> <!-- footer copyright -->
  </footer>
  <!--====== FOOTER PART ENDS ======-->
  <!--====== BACK TO TOP PART START ======-->
  <a class="back-to-top" href="javascript:;"><i class="fas fa-chevron-up"></i></a>
  <!--====== BACK TO TOP PART ENDS ======-->
  <!-- Core JavaScript Plugins -->
  <script src="{{ asset('js/vendor/modernizr-3.6.0.min.js') }}"></script>
  <script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('datatables/datatables.min.js') }}"></script>
  <!-- Include JavaScript -->
  <script src="{{ asset('js/custom.js') }}"></script>
  <!--====== BACK TO TOP PART ENDS ======-->
  <!-- Include Back to Top Button -->
  <a class="back-to-top" href="javascript:;"><i class="fas fa-chevron-up"></i></a>
  <!-- Core JavaScript Plugins -->
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <!-- Scrolling Nav JS -->
  <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/scrolling-nav.js') }}"></script>
  <!-- Magnific Popup JS -->
  <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
  <!-- owlcarousel JS -->
  <script src="<?= url('owl-carousel/dist') ?>/owl.carousel.min.js"></script>
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.x.x/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Main JS -->
  <script src="{{ asset('js/main.js') }}"></script>
  <!-- Selectize JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
    integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <!-- jQuery Plugin for Number Input Formatting -->
  <script
    src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Number-Input-Formatting-Mask-Number/jquery.masknumber.js">
  </script>
  <!-- Custom JavaScript -->
  <script type="text/javascript">
    function formatRupiah(angka) {
      var number_string = angka.toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return rupiah;
    }

    $(document).ready(function() {
      $('select').selectize({
        sortField: 'text'
      });

      @if (Session::has('id_pelanggan'))
        $("#countCart").text("{{ $getItem }}");
      @endif
    });

    $('#input-number').maskNumber({
      integer: true
    });
  </script>
  {{-- owl-carousel --}}
  <script>
    $(document).ready(function() {
      $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 2
          },
          1000: {
            items: 3
          },
          1200: {
            items: 4
          }
        },
        navText: ["<i class='fa-solid fa-arrow-left'></i>", "<i class='fa-solid fa-arrow-right'></i>"]
      });
    });
  </script>

</body>

</html>
