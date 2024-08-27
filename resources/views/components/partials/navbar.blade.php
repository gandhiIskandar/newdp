<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="../assets/images/logo-white.svg" alt="logo image" class="logo-lg" />
                <span class="badge bg-primary rounded-pill ms-2 theme-version">v3.1.0</span>
            </a>
        </div>



        <div class="card pc-user-card">
            <div class="card-body">
                <div class="nav-user-image">
                    <a data-bs-toggle="collapse" href="#navuserlink">
                        <img src="{{ asset('storage/' . $userNav->profile_image) }}" alt="user-image"
                            class="user-avtar rounded-circle" style="object-fit:cover; height:100px; width:100px;" />
                    </a>
                </div>
                <div class="pc-user-collpsed collapse" id="navuserlink">
                    <h4 class="mb-0">{{ $userNav->name }}</h4>
                    <span>{{ $userNav->role->name }}</span>
                    <ul>
                        <li><a class="pc-user-links" href="/account_setting">
                                <i class="ph-duotone ph-user"></i>
                                <span>My Account</span>
                            </a></li>
                        {{-- <li><a class="pc-user-links">
                                <i class="ph-duotone ph-gear"></i>
                                <span>Settings</span>
                            </a></li> --}}
                        {{-- <li><a class="pc-user-links">
                                <i class="ph-duotone ph-lock-key"></i>
                                <span>Lock Screen</span>
                            </a></li> --}}

                        <li>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="bg-transparent border-0 m-0 p-0 w-100">
                                    <a class="pc-user-links">
                                        <i class="ph-duotone ph-power"></i>
                                        <span>Logout</span>
                                    </a>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        <div class="navbar-content">
            @if (session('website_id') != 5 && session('website_id') != 6)
                <ul class="pc-navbar">


                    @if (privilegeViewDashboard())
                        <li class="pc-item {{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="/dashboard" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-gauge"></i>
                                </span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                    @endif
                    @if (privilegeViewTransaction())
                        <li class="pc-item {{ request()->is('transactions') ? 'active' : '' }}">
                            <a href="/transactions" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-money"></i>
                                </span>
                                <span class="pc-mtext">Transaksi</span>
                            </a>
                        </li>
                    @endif
                    @if (privilegeViewMember())
                        <li class="pc-item {{ request()->is('members') ? 'active' : '' }}">
                            <a href="/members" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-user"></i>
                                </span>
                                <span class="pc-mtext">Member</span>
                            </a>
                        </li>
                    @endif


                    @if (privilegeViewAdminAccount())
                        <li class="pc-item {{ request()->is('rekening') ? 'active' : '' }}">
                            <a href="/rekening" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-bank"></i>
                                </span>
                                <span class="pc-mtext">Rekening Admin</span>
                            </a>
                        </li>
                    @endif

                    {{-- @can('superAdmin')
                         <li class="pc-item {{ request()->is('users') ? 'active' : '' }}">
                            <a href="/users" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-users"></i>
                                </span>
                                <span class="pc-mtext">Users</span>
                            </a>
                        </li> 
                    @endcan --}}

                    @if (privilegeViewLog())
                        <li class="pc-item {{ request()->is('log') ? 'active' : '' }}">
                            <a href="/log" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-activity"></i>
                                </span>
                                <span class="pc-mtext">Log</span>
                            </a>
                        </li>
                    @endif


                    @if (privilegeChangePassword() || privilegeEditUserData())
                        <li class="pc-item {{ request()->is('account-setting') ? 'active' : '' }}">
                            <a href="/account_setting" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-user-circle-gear"></i>
                                </span>
                                <span class="pc-mtext">Setting Akun</span>
                            </a>
                        </li>
                    @endif

                </ul>
            @elseif(session('website_id') == 5)
                {{-- TT Atas --}}


                <ul class="pc-navbar">
                    <li class="pc-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-gauge"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>



                    @if (privilegeViewTTAtas())
                        <li class="pc-item {{ request()->is('tt-atas') ? 'active' : '' }}">
                            <a href="/tt-atas" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-money"></i>
                                </span>
                                <span class="pc-mtext">TT Atas</span>
                            </a>
                        </li>
                    @endif

                    @if (privilegeViewLog())
                    <li class="pc-item {{ request()->is('log-transfer') ? 'active' : '' }}">
                        <a href="/log-transfer" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-activity"></i>
                            </span>
                            <span class="pc-mtext">Log</span>
                        </a>
                    </li>
                @endif

                    @if (privilegeViewPinjamAtas())
                        <li class="pc-item {{ request()->is('pinjam-atas') ? 'active' : '' }}">
                            <a href="/pinjam-atas" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-money"></i>
                                </span>
                                <span class="pc-mtext">Pinjam Atas</span>
                            </a>
                        </li>
                    @endif

                    @if (privilegeViewAdminAccount())
                        <li class="pc-item {{ request()->is('rekening') ? 'active' : '' }}">
                            <a href="/rekening" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-bank"></i>
                                </span>
                                <span class="pc-mtext">Rekening</span>
                            </a>
                        </li>
                    @endif

                </ul>
            @else
                {{-- Fitur Umum --}}



                <ul class="pc-navbar">
                    <li class="pc-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-gauge"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>





                    @if (privilegeViewCashBook())
                        <li class="pc-item {{ request()->is('cashbooks') ? 'active' : '' }}">
                            <a href="/cashbooks" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-book"></i>
                                </span>
                                <span class="pc-mtext">Kas</span>
                            </a>
                        </li>
                    @endif

                    @if (privilegeViewExpenditure())
                        <li class="pc-item {{ request()->is('expenditures') ? 'active' : '' }}">
                            <a href="/expenditures" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-book"></i>
                                </span>
                                <span class="pc-mtext">Pengeluaran</span>
                            </a>
                        </li>
                    @endif

                </ul>
            @endif

        </div>
    </div>
</nav>
