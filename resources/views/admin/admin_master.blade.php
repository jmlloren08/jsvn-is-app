<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>JSVN | Inventory Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('backend/assets/images/favicon.ico') }}">
    <!-- jquery.vectormap css -->
    <link href="{{ url('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- jquery -->
    <script src="{{ url('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <!-- DataTables -->
    <link href="{{ url('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ url('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ url('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ url('backend/assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- select2 -->
    <link href="{{ url('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
</head>

<body data-topbar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.body.header')
        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.body.sidebar')
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            @yield('admin')
            <!-- End Page-content -->
            @include('admin.body.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <script src="{{ url('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ url('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ url('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <!-- jquery.vectormap map -->
    <script src="{{ url('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ url('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ url('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ url('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/assets/js/pages/dashboard.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ url('backend/assets/js/app.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ url('backend/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ url('backend/assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- form advanced -->
    <script src="{{ url('backend/assets/js/pages/form-advanced.init.js') }}"></script>
</body>

</html>