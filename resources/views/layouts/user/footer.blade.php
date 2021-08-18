@section('footer')
<footer class="footer">
    <div class="container-fluid">
        <div class="row text-muted">
            <div class="col-8 text-left">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a class="text-muted" href="#">Support</a>
                    </li>
                    <li class="list-inline-item">
                        <a class="text-muted" href="#">Privacy</a>
                    </li>
                    <li class="list-inline-item">
                        <a class="text-muted" href="#">Terms of Service</a>
                    </li>
                    <li class="list-inline-item">
                        <a class="text-muted" href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="col-4 text-right">
                <p class="mb-0">
                    &copy; {{ date('Y') }} - <a href="{{ url('/dashboard') }}" class="text-muted">{{ env('APP_NAME') }}</a>
                </p>
            </div>
        </div>
    </div>
</footer>
@endsection