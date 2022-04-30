<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PaimonShop - Hệ thống quản trị Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/bower_components/bootstrap/dist/css/bootstrap.min.css?v={{time()}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/bower_components/font-awesome/css/font-awesome.min.css?v={{time()}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/bower_components/Ionicons/css/ionicons.min.css?v={{time()}}">

    <!--Select2-->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/bower_components/select2/dist/css/select2.min.css?v={{time()}}">

    <!--Data table-->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css?v={{time()}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/dist/css/AdminLTE.css?v={{time()}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/iCheck/square/blue.css?v={{time()}}">

    <link rel="stylesheet" href="{{ asset('adminLTE') }}/dist/css/skins/_all-skins.min.css?v={{time()}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css?v={{time()}}">
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/bower_components/nestable2/nestable2.css?v={{time()}}">
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/dist/css/custom.css?v={{time()}}">

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" sizes="32x32">
</head>
<body class="skin-blue sidebar-mini wysihtml5-supported" style="height: auto; min-height: 100%;">

<div id="app" class="wrapper" style="height: auto; min-height: 100%;">
    @include('admin.partial.header')
    @include('admin.partial.sidebar')
    <div class="content-wrapper" style="min-height: 925.8px;">
        <!-- Content Header (Page header) -->
        @yield('content')
    </div>
    @include('admin.partial.footer')
</div>

<!-- jQuery 3 -->
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/jquery/dist/jquery.min.js?v={{time()}}"></script>
<!-- jQuery UI 1.11.4 -->
{{--<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/jquery-ui/jquery-ui.min.js?v={{time()}}s"></script>--}}
<!-- Bootstrap 3.3.7 -->
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/bootstrap/dist/js/bootstrap.min.js?v={{time()}}"></script>
<!-- iCheck -->
<script type="text/javascript" src="{{ asset('adminLTE') }}/plugins/iCheck/icheck.min.js?v={{time()}}"></script>

<!--Data Table-->
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/datatables.net/js/jquery.dataTables.min.js?v={{time()}}"></script>
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js?v={{time()}}"></script>

<!--momment js-->
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/moment/min/moment-with-locales.min.js?v={{time()}}"></script>
<script type="text/javascript" src="{{ asset('adminLTE') }}/dist/js/adminlte.js?v={{time()}}"></script>
<!-- CK Editor -->
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/ckeditor/ckeditor.js?v={{time()}}"></script>
<script type="text/javascript" src="{{ asset('adminLTE') }}/plugins/ckfinder/ckfinder.js?v={{time()}}"></script>

<!--Select2-->
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/select2/dist/js/select2.full.min.js?v={{time()}}"></script>
<script type="text/javascript" src="{{ asset('adminLTE') }}/bower_components/nestable2/nestable2.js?v={{time()}}"></script>

<script type="text/javascript">
    var appUrl = '{{ config('app.url') }}';
    var backendUrl = '{{ url('/admin') }}';
    var _token = '{{ csrf_token() }}';
    var filebrowserBrowseUrl = '{{ route('ckfinder_browser') }}';
    var imgDefault = '{{ asset('adminLTE/dist/img/no-img.png') }}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
<script type="text/javascript" src="{{ asset('adminLTE') }}/dist/js/custom.js?v={{time()}}"></script>
@include('plugins.ckfinder.setup')
@stack('script')
<script type="text/javascript">
    CKFinder.config( { connectorPath: '/cms/ckfinder/connector' } );
</script>
</body>
</html>
