<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-red" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Audit</div>
                <a href="{{ route('dashboard') }}" class="nav-link">
                    Dashboard
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-right"></i></div>
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#casting"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    ACK AHM - CASTING
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="casting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link collapsed dropdown-keep-open" href="{{ url('/checksheetcasting') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboardcasting') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ url('/add-empty-data-casting') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Previous Day</span>
                        </a>
                        <a class="nav-link" href="{{ url('/castinghistory') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span>
                        </a>
                    </nav>
                </div>


                {{-- Machining --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#machining"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    ACK AHM - MACHINING
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="machining" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('/checksheetmachining') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboardmachining') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ url('/add-empty-data-machining') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Previous Day</span>
                        </a>
                        <a class="nav-link" href="{{ url('/machining-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span>
                        </a>
                    </nav>
                </div>


                {{-- Painting --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#painting"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    ACK AHM - PAINTING
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="painting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('/checksheetpainting') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboard-painting') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ url('/add-empty-data-painting') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Previous Day</span>
                        </a>
                        <a class="nav-link" href="{{ url('/painting-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span>
                        </a>
                    </nav>
                </div>


                {{-- Assy --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#assy"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    ACK AHM - ASSY
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="assy" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('/checksheetassy') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboard-assy') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ url('/add-empty-data-assy') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Previous Day</span>
                        </a>
                        <a class="nav-link" href="{{ url('/assy-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span></a>
                    </nav>
                </div>
                {{-- Supplier --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#supp"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    ACK AHM - SUPPLIER INTERNAL
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="supp" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        {{-- <a class="nav-link" href="{{ url('/checksheetsupp') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span></a> --}}
                        <a class="nav-link" href="{{ route('internal.dashboard.supplier') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span></a>
                        <a class="nav-link" href="{{ route('internal.supplierHistory') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span></a>
                    </nav>
                </div>



                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#subsect"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    ACK AHM - SUBSECTION
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="subsect" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        {{-- <a class="nav-link" href="{{ url('/checksheetsupp') }}">
                        <i class="fas fa-file-alt"></i>
                        <span style="margin-left: 5px;">Checksheet</span></a> --}}
                        <a class="nav-link" href="{{ route('subsection.index') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span></a>
                    </nav>
                </div>





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
