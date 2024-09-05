<!doctype html>
<html lang="id">
<!-- [Head] start -->

<head>
    <title>{{ $title ?? 'Page Title' }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />





    @stack('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>

    </style>


    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <!-- [Google Font : Public Sans] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css" rel="stylesheet">
    {{-- end data table --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css"
        integrity="sha512-YdYyWQf8AS4WSB0WWdc3FbQ3Ypdm0QCWD2k4hgfqbQbRCJBEgX0iAegkl2S1Evma5ImaVXLBeUkIlP6hQ1eYKQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link href="{{ asset('assets/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css" />


</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-theme="dark" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    {{-- <div class="loader-bg">
        <div class="pc-loader">
            <div class="loader-fill"></div>
        </div>
    </div> --}}
    <!-- [ Pre-loader ] End -->

    @php
        $userNav = session('user_data');
    @endphp


    <!-- [ Sidebar Menu ] start -->
    @include('components.partials.navbar')

    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    @include('components.partials.header')
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">

        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-sm-auto">
                            <div class="page-header-title">
                                <h5 class="mb-0">{{ $title ?? 'Page Title' }}</h5>
                            </div>
                        </div>
                        {{-- <div class="col-sm-auto">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../navigation/index.html"><i
                                            class="ph-duotone ph-house"></i></a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $title ?? 'Page Title' }}</li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->

            {{ $slot }}

            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <x-partials.footer />
    <x-partials.ui-settings />

    <livewire:modal-change-password />
    <livewire:whitelist.modal-whitelist />

    <livewire:website.modal-website />

    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/dashboard-finance.js') }}"></script>  --}}
    <!-- [Page Specific JS] end -->

    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.8.1/autoNumeric.min.js"></script>

    {{-- data table --}}
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
    {{-- end data table --}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"
        integrity="sha512-RCgrAvvoLpP7KVgTkTctrUdv7C6t7Un3p1iaoPr1++3pybCyCsCZZN7QEHMZTcJTmcJ7jzexTO+eFpHk4OCFAg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    @stack('script')



    <script>
        layout_change(getCookie('layout') != "" ? getCookie('layout') : "light");
    </script>

    <script>
        layout_sidebar_change(getCookie('sidebar') != "" ? getCookie('sidebar') : 'dark');
    </script>

    <script>
        layout_header_change(getCookie('header') != "" ? getCookie('header') : 'dark');
    </script>

    {{-- <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script> --}}

    <script>
        preset_change(getCookie('preset-color') != "" ? getCookie('preset-color') : 'preset-1');
    </script>

    <script>
        $(function() {
            if ($('.input-currency').length) {
               
                new AutoNumeric('.input-currency', {
                    currencySymbol: '',
                    decimalCharacter: ',',
                    decimalPlaces: 0,
                    digitGroupSeparator: '.',
                });
            }

        });
    </script>



    @livewireScripts

</body>
<!-- [Body] end -->

</html>
