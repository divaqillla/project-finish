<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-red" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Audit</div>




                {{-- <a href="{{ route('dashboard') }}" class="nav-link">
                    Dashboard
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-right"></i></div>
                </a> --}}

                {{-- Supplier --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#supp"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    AUDIT SUPPLIER
                    {{-- <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div> --}}
                </a>
                {{-- <div class="collapse" id="supp" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav"> --}}
                        <a class="nav-link" href="{{ url('/checksheetsupp') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span></a>
                        <a class="nav-link" href="{{ url('/dashboard-supplier') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span></a>
                        <a class="nav-link" href="{{ url('/supplier-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span></a>
                    {{-- </nav>
                </div> --}}





            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>
<style>
    .sb-sidenav-red {
        background-color: rgb(255, 255, 255);
        /* Atur warna latar belakang menjadi merah */
    }
</style>
