@extends('frontend.v-2.master')

@section('title')
    Career
@endsection

@section('content-v2')
    <section class="future-program-section">        
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="future-program-section-video-outer">
                        <div class="section-bg-outer">
                            <img src="{{ asset('/frontend/') }}/assets/images/mission.jpg">
                        </div>
                        {{-- <div class="video-icon-outer">
                            <a href="https://www.youtube.com/watch?v=knXIBwAWOWo" target="_blank">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="future-program-section-content">
                        <h4 class="title">
                            Job Details
                        </h4>
                        <p class="des"> 
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p class="des"> 
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <div class="text-center mt-3">
                            <a href="#" class="apply-btn">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
