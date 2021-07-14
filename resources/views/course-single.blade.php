@extends('layouts.app')
@include('layouts.header')
@section('home')
    <section class="course-banner d-flex">
            <div class="container">
                <div class="row"> 
                    <div class="col-lg-12 col-sm-12 align-items-center d-flex justify-content-center course-banner-row">
                        <div class="banner-content course-banner-content">
                            <h1>Course Name</h1>
                        </div>
                    </div>
                </div>
                
            </div>
    </section>
    <section class="course-description main-page-section">
        <div class="container section-container">
            <div class="pt-lg-12 pb-lg-12 py-6 ">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-12 mb-8">
                        <div>
                            <ul class="nav-pills-border nav nav-pills nav-justified mb-5 " id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold active" id="pills-Overview-tab" data-toggle="pill" href="#pills-Overview" role="tab" aria-controls="pills-Overview" aria-selected="true">Overview</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link font-weight-bold " id="pills-Curriculum-tab" data-toggle="pill" href="#pills-Curriculum" role="tab" aria-controls="pills-Curriculum" >Curriculum</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="pills-Coach-tab" data-toggle="pill" href="#pills-Coach" role="tab" aria-controls="pills-Coach" aria-selected="false">Coach</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade active show" id="pills-Overview" role="tabpanel" aria-labelledby="pills-Overview-tab">
                                <div>
                                    <p class="text-dark lead">
                                    We work with you to equip your leaders with the skills
                                    they need to deliver for themselves, their team and your
                                    business.
                                    </p>
                
                                    <p>
                                    We believe that effective leaders will help drive your
                                    business forward, and we are passionate about people
                                    development. We have been helping to develop inspiring,
                                    confident, and authentic leaders for over 15 years,
                                    designing bespoke solutions to help your managers become
                                    great leaders.
                                    </p>
                                    <p>
                                    We work with you to understand your vision and values,
                                    goals and ambitions, and design motivational learning
                                    interventions to make sure your people are in the best
                                    position to deliver these goals.
                                    </p>
                                    <h3 class="mb-3 mt-4">What you will learn</h3>
                                    <div class="mb-3">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                        <ul class="list-unstyled">
                                            <li>
                                            <i class="fas fa-check-circle mr-2 font-13 text-success"></i>Strategic business partner
                                            </li>
                                            <li>
                                            <i class="fas fa-check-circle mr-2 font-13 text-success"></i>Experienced outside view
                                            </li>
                                            <li>
                                            <i class="fas fa-check-circle mr-2 font-13 text-success"></i>Unbiased objective advice
                                            </li>
                                            <li>
                                            <i class="fas fa-check-circle mr-2 font-13 text-success"></i>Bespoke tailored approach
                                            </li>
                                        </ul>
                                        </div>
                                        <div class="col-lg-7 col-md-6 col-12">
                                        <ul class="list-unstyled">
                                            <li>
                                            <i class="fas fa-check-circle mr-2 font-13 text-success"></i>Inspiration for your team to reach their potential to achieve their goals
                                            </li>
                                            <li>
                                            <i class="fas fa-check-circle mr-2 font-13 text-success"></i>Flexibility
                                            </li>
                                            <li>
                                            <i class="fas fa-check-circle mr-2 font-13 text-success"></i>No permanent cost base
                                            </li>
                                            
                                        </ul>
                                        </div>
                                    </div>
                                    </div>
                
                                    <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Aenean mattis blandit felis nec vestibulum. Sed cursus
                                    vitae eros eget blandit. Sed tortor turpis, condimentum
                                    vel convallis sed, finibus in augue. Vestibulum nulla
                                    diam, finibus quis lorem quis, congue mollis quam. Duis
                                    tincidunt sodales turpis, vitae laoreet nulla luctus in.
                                    </p>
                                    <h3 class="mb-3 mt-4">How we do it?</h3>
                                    <p class="mb-4">
                                    Donec vitae mattis lorem, nec elementum metus. Nunc et
                                    lacus imperdiet, convallis quam lobortis, placerat nisi.
                                    Nunc at rutrum mi, sed consequat purus. Pellentesque
                                    congue magna sit amet bibendum dignissim. Fusce volutpat
                                    et ex id facilisis.
                                    </p>
                                    <a href="#!" class="btn btn-warning">Enroll This Courses</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="pills-Curriculum" role="tabpanel" aria-labelledby="pills-Curriculum-tab">
                
                                    <div>
                                        <div class="card course-card mb-4">
                                            <div class="card-body">
                                                <div class="d-lg-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <h4 class="mb-1">Foundations of Leadership Coaching</h4>
                                                        <p class="font-14">Vestibulum eu ex consectetur aliquempor nisl.</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-secondary text-uppercase">Week-1</h5>
                                                    </div>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item course-price-itmes px-0">
                                                        <div class="d-md-flex justify-content-between align-items-center">
                
                                                            <h5 class="mb-0">What is Leadership development?</h5>
                
                                                            <span class="mb-0">1m 19s</span>
                
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item course-price-itmes px-0">
                                                        <div class="d-md-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h5 class="mb-0">Declare your promise to your customers</h5>
                                                            </div>
                                                            <div>
                                                                <p class="mb-0">3m 28s</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item course-price-itmes px-0">
                                                        <div class="d-md-flex justify-content-between align-items-center">
                
                                                            <h5 class="mb-0">Values &amp; Vision - Leading the Way</h5>
                
                                                            <span class="mb-0">2m 30s</span>
                
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item course-price-itmes px-0 pb-0">
                                                        <div class="d-md-flex justify-content-between align-items-center">
                
                                                            <h5 class="mb-0">Time &amp; Energy Management</h5>
                
                                                            <span class="mb-0">3m 30s</span>
                
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-Coach" role="tabpanel" aria-labelledby="pills-Coach-tab">
                                    <div>
                                        <div class="card course-card">
                                            <div class="card-body p-4">
                                                <div class="media align-items-center mb-4">
                                                    <img src="../assets/images/avatar-9.png" alt="" class="rounded-circle mr-3">
                                                    <div class="media-body">
                                                        <h4 class="mb-1">Randall Williamson</h4>
                                                        <p class="mb-0">Leadership Speaker, Foremost Expert in the Leadership and Management </p>
                                                    </div>
                                                </div>
                                                <h5 class="mb-3">About Speaker Randall Williamson</h5>
                                                <p>Randall Williamson is a Leadership keynote speaker, the CEO and founder of LeadCaoch. Morbi vehicula risus ante, vel ultricies ligula tincidunt quis. Morbi eros est, luctus nec porttitor a, dapibus nec lorem. </p>
                                                <p class="mb-0">Integer quis aliquam eros. Phasellus tortor lacus, malesuada id varius eget, dignissim ac augue. Aenean congue magna nunc, vitae ornare nisi sollicitudin at.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- sidebar -->
                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12 mb-8">
                        <div class="card course-card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item  course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-money-bill-alt mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Program Price</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 text-primary font-weight-bold">$35.00</h5>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-tie mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Coach</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 text-dark">Randall Williamson</h5>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Duration</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted">4 weeks</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-alt mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Lectures</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted">18</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Enrolled</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted">54 students</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <a href="#!" class="btn btn-secondary btn-block">Enroll This Courses</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('layouts.footer')