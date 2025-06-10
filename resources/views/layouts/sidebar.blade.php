@php
    $menus = [
        1 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object) [
                'title' => 'Daftar Anak Magang',
               'path' => 'account-list',
                'icon' => 'fas fa-fw fa-table',
           ],
           // (object) [
             //  'title' => 'Manajemen Akun',
              //  'path' => 'anak_magangs',
                //'icon' => 'fas fa-fw fa-cog',
            //],
            (object) [
                'title' => 'Permintaan Akun',
                'path' => 'account-request',
                'icon' => 'fas fa-fw fa-plus',
            ],
            (object) [
                'title' => 'Semua Tugas',
                'path' => 'admin/all-submissions',
                'icon' => 'fas fa-list-ul',
            ],
        ],
        2 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object) [
                'title' => 'Pengumpulan Tugas',
                'path' => 'submission',
                'icon' => 'fas fa-tasks',
            ],
        ],
    ];
@endphp       
       <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('template/img/logokominfo.png') }}" alt="Logo Kominfo" style="width: 50px; height: 50px;">
                </div>
                <div class="sidebar-brand-text mx-2">KominfoMuda</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <!-- <li class="nav-item {{  request()-> is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li> -->

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Manajemen Data
            </div> -->

            <!-- Nav Item - Tables -->
            @auth
                @foreach ($menus[auth()->user()->role_id] as $menu)
                    <li class="nav-item {{  request()-> is($menu->path.'*') ? 'active' : '' }}">
                        <a class="nav-link" href="/{{ $menu -> path }}">
                            <i class="{{$menu -> icon}}"></i>
                            <span>{{$menu -> title}}</span></a>
                    </li>
                @endforeach
            @endauth

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>