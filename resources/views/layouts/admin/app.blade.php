<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <script>
        var siteUrl = {!! json_encode(url("/")) !!};
    </script>

    <link href="{{ url('css/admin.css') }}" rel="stylesheet">
    <script src="{{ url('js/adminTop.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/emnobbhpgbq07h8fphlimqtkkglockm9b06sspmkz8mg92ly/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<body>
    <div class="splash active">
		<div class="splash-icon"></div>
	</div>
    @yield('login')
    <div class="wrapper">
        @yield('sidebar')
        <div class="main">
            @yield('header')
            @yield('home')
            @yield('footer')
        </div>
    </div>
    <script src="{{ url('js/admin.js') }}"></script>
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
    @yield('scripts')
</body>

</html>