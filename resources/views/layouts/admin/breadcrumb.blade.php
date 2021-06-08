<ol class="breadcrumb">
    @php
        $link = "";
    @endphp 
    @for($i = 1; $i <= count(Request::segments()); $i++)
        @if($i < count(Request::segments()))
        @php
            $link .= "/" . Request::segment($i);
        @endphp
        <li class="breadcrumb-item"><a href="{{ $link }}">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a></li>
        @else
        <li class="breadcrumb-item active" aria-current="page">{{  ucwords(str_replace('-',' ',Request::segment($i))) }}</li>
        
        @endif
    @endfor
</ol>