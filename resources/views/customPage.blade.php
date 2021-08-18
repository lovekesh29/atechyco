@extends('layouts.app')
@include('layouts.header')
@section('meta')
<meta name="description" content="{{ $pageDetail->metaDescription }}">
    <title>{{ $pageDetail->metaTitle }}</title>
@endsection
@section('home')
@if (Session::has('status'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "{{ Session::get('status') }}"
    })
</script>    
@endif
    <section class="course-banner d-flex" style="background: linear-gradient( 180deg, rgba(30, 24, 53, 0.4) 0%, rgba(30, 24, 53, 0.4) 90.16%), url(../storage/pageBanner/{{ $pageDetail->id }}/{{ $pageDetail->bannerImage }}) no-repeat center;">
            <div class="container">
                <div class="row"> 
                    <div class="col-lg-12 col-sm-12 align-items-center d-flex justify-content-center course-banner-row">
                        <div class="banner-content course-banner-content">
                            <h1>{{ $pageDetail->bannerHeading }}</h1>
                        </div>
                    </div>
                </div>
                
            </div>
    </section>
    <section class="course-description main-page-section">
        <div class="container section-container">
            <div class="pt-lg-12 pb-lg-12 py-6 ">
                <h1 class="text-center m-auto pb-5">{{ $pageDetail->pageHeading }}</h1>
               {!! substr($pageDetail->pageContent, 0, 250) !!}

                <img src="{{ url('/storage/pageImage/'.$pageDetail->id.'/'.$pageDetail->pageImage) }}" style="width: 400px; height: 230px" class="float-right p-5" alt="" >

                {!! substr($pageDetail->pageContent, 251) !!}
                
            </div>
        </div>
    </section>
@endsection
@include('layouts.footer')