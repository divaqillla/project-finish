<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    {{-- <title>{{ $judul }} | Dashboard - SB Admin </title> --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    {{-- <link href="/css/styles.css" rel="stylessheet"/> --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #a8c5e6;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="{{ asset('assets/img/logonm.png') }}" style="width: 170px; height: auto;">
            </a>
            {{-- <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" style="color: rgb(31, 42, 164)"
                id="sidebarToggle" href="#!">
                <i class="fas fa-bars"></i>
            </button> --}}
            <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1">
                <!-- Tanggal saat ini -->
                <div class="clock-date" style="color: rgb(31, 42, 164); font-size: 1rem; "></div>
                <!-- Waktu saat ini -->
                <div class="clock-time" style="color: rgb(31, 42, 164); font-size: 1rem;"></div>
            </div>
            <!-- Sidebar Toggle-->

        </div>
        <!-- Navbar Search-->
        {{-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form> --}}
        <!-- Navbar-->
        {{-- <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul> --}}
    </nav>
    <div id="layoutSidenav">
        {{-- @include('layouts/partials/sidebar') --}}
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    {{-- <h1 class="mt-4">{{ $judul }}</h1> --}}
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Dipadipo</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        function updateTime() {
            var now = new Date();
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                'November', 'Desember'
            ];

            var dayOfWeek = days[now.getDay()];
            var dayOfMonth = now.getDate();
            var month = months[now.getMonth()];
            var year = now.getFullYear();

            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Padding zero jika jam, menit, atau detik < 10
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            var dateString = dayOfWeek + ', ' + dayOfMonth + ' ' + month + ' ' + year;
            var timeString = hours + ' : ' + minutes + ' : ' + seconds + ' WIB';

            document.querySelector('.clock-date').textContent = dateString;
            document.querySelector('.clock-time').textContent = timeString;
        }

        // Panggil updateTime setiap detik
        setInterval(updateTime, 1000);

        // Panggil updateTime saat halaman dimuat pertama kali
        updateTime();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    {{-- <script src="js/scripts.js"></script> --}}
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    {{-- <script src="assets/demo/chart-area-demo.js"></script> --}}
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    {{-- <script src="assets/demo/chart-bar-demo.js"></script> --}}
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    {{-- <script src="js/datatables-simple-demo.js"></script> --}}
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    @stack('js')
</body>

</html>
