@extends('frontend.v-2.master')

@section('title')
    Contact Us
@endsection

@section('content-v2')
    <section class="contact-section-wrapper pt-5 pb-5">
      <div class="privacy-policy-heading-wrapper">
          <div class="section-heading-outer">
              <h4 class="section-heading-inner">
                  Contact Us
              </h4>
          </div>
      </div>
      <div class="container">
          <div class="row">
              <div class="col-md-4">
                  <div class="contact-info-item wow fadeInLeftBig">
                      <div class="contact-info-icon">
                          <i class="fas fa-phone-alt"></i>
                      </div>
                      <h5 class="title">
                          Phone
                      </h5>
                      <a href="tel:">{{$setting->phone}}</a>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="contact-info-item wow flipInX">
                      <div class="contact-info-icon">
                          <i class="fas fa-envelope"></i>
                      </div>
                      <h5 class="title">
                          Email
                      </h5>
                      <a href="mailto:">{{$setting->email}}</a>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="contact-info-item wow fadeInRightBig">
                      <div class="contact-info-icon">
                          <i class="fas fa-map-marker-alt"></i>
                      </div>
                      <h5 class="title">
                          Address
                      </h5>
                      <p>
                        {{$setting->address}}
                      </p>
                  </div>
              </div>
          </div>
          <div class="contact-form-wrapper wow flipInX">
              <div class="row">
                  <div class="col-md-8 m-auto">
                      <form action="{{ url('/contact/store') }}" method="post" class="contact-form form-group">
                          @csrf
                          <div class="row">
                              <div class="col-md-6">
                                  <label for="name">
                                      Name
                                  </label>
                                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your name">
                                  @error('name')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="col-md-6">
                                  <label for="phone">
                                      Phone
                                  </label>
                                  <input type="text" name="phone" class="form-control  @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Enter phone number">
                                  @error('phone')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="col-md-12">
                                  <label for="email">
                                      Email
                                  </label>
                                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email">

                                  @error('email')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="col-md-12">
                                  <label for="message">
                                      Message
                                  </label>
                                  <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Your Message">{{ old('message') }}</textarea>
                                  @error('message')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                          </div>
                          <div class="contact-submit-btn-outer">
                              <button class="contact-submit-btn-inner" type="submit">
                                  Send Message <i class="fas fa-paper-plane"></i>
                              </button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
        <br/>
{{--        <div class="mapouter"><div class="gmap_canvas"><iframe width="1920" height="510" id="gmap_canvas" src="https://maps.google.com/maps?q=Webcoder-it&t=&z=10&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://2yu.co">2yu</a><br><style>.mapouter{position:relative;text-align:right;height:510px;width:100%;}</style><a href="https://embedgooglemap.2yu.co">html embed google map</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:510px;width:100%;}</style></div></div>--}}
    </section>
@endsection
