<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        var siteUrl = {!! json_encode(url("/")) !!};
        </script>
    <title></title>

    <link href="{{ url('css/guru.css') }}" rel="stylesheet">
    <script src="{{ url('js/guruTop.js') }}"></script>

<body >
    <div class="splash active">
		<div class="splash-icon"></div>
	</div>
    <div class="wrapper">
        @yield('sidebar')
        <div class="main">
            @yield('header')
            @yield('home')
            @yield('footer')
        </div>
    </div>
    <script src="{{ url('js/guru.js') }}"></script>
    <script>
        $(function() {
            $('#datatables-dashboard-projects').DataTable({
                pageLength: 6,
                lengthChange: false,
                bFilter: false,
                autoWidth: false
            });
        });
    </script>
    <script>
        $(function() {
            $('#datetimepicker-dashboard').datetimepicker({
                inline: true,
                sideBySide: false,
                format: 'L'
            });
        });
    </script>
</body>

</html>