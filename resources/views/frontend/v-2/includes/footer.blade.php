<footer class="footer-section">
    <div class="footer__top-wrapper">
        <div class="container">
            <a href="#" class="footer__brand-logo-outer">
                <img src="{{asset('setting/'.$setting->logo)}}" class="footer__brand-logo-inner" />
            </a>
        </div>
    </div>
    <div class="footer__main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer__item-wrap">
                        <h4 class="footer__item-title">
                            Policy
                        </h4>
                        <ul class="footer__list">
                            <li class="footer__list-item">
                                <a href="{{ url('/privacy-policy') }}" class="footer__list-item-link">
                                    Privacy Policy
                                </a>
                            </li>
                            <li class="footer__list-item">
                                <a href="{{ url('/term-conditions') }}" class="footer__list-item-link">
                                    Terms & Conditions
                                </a>
                            </li>
                            <li class="footer__list-item">
                                <a href="{{ url('/refund-policy') }}" class="footer__list-item-link">
                                    Refund Policy
                                </a>
                            </li>
                            <li class="footer__list-item">
                                <a href="{{ url('/payment-policy') }}" class="footer__list-item-link">
                                    Payment Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer__item-wrap">
                        <h4 class="footer__item-title">
                           Contacts
                        </h4>
                        <ul class="footer__contact-info-list">
                            <li class="footer__contact-info-list-item">
                                <p class="footer__contact-info-list-item-label">
                                    Address:
                                </p>
                                <p class="footer__contact-info-list-item-value">
                                    {{ $setting->address ?? '' }}
                                </p>
                            </li>
                            <li class="footer__contact-info-list-item">
                                <p class="footer__contact-info-list-item-label">
                                    Phone:
                                </p>
                                <a href="tel:{{ $setting->phone  }}" class="footer__contact-info-list-item-value">
                                    {{ $setting->phone ?? '' }}
                                </a>
                            </li>
                            <li class="footer__contact-info-list-item">
                                <p class="footer__contact-info-list-item-label">
                                    Email:
                                </p>
                                <a href="mailto:{{ $setting->email  }}" class="footer__contact-info-list-item-value">
                                    {{ $setting->email ?? '' }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer__item-wrap">
                        <h4 class="footer__item-title">
                            Others
                        </h4>
                        <ul class="footer__list">
                            <li class="footer__list-item">
                                <a href="{{ url('/about-us') }}" class="footer__list-item-link">
                                    About Us
                                </a>
                            </li>
                            <li class="footer__list-item">
                                <a href="{{ url('/contact-us') }}" class="footer__list-item-link">
                                    Contact Us
                                </a>
                            </li>
                            <li class="footer__list-item">
                                <a href="{{ url('/all/blogs') }}" class="footer__list-item-link">
                                    Blog
                                </a>
                            </li>
                            <li class="footer__list-item">
                                <a href="{{ url('/career') }}" class="footer__list-item-link">
                                    Careers
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer__item-wrap">
                        <h4 class="footer__item-title">
                            Follow Us
                        </h4>
                        <ul class="footer__social-list">
                            <li class="footer__social-list-item">
                                <a href="{{ $setting->facebook ?? '' }}" class="footer__social-list-item-lisk">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="footer__social-list-item">
                                <a href="{{ $setting->twitter ?? '' }}" class="footer__social-list-item-lisk">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li class="footer__social-list-item">
                                <a href="{{ $setting->instagram ?? '' }}" class="footer__social-list-item-lisk">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="footer__social-list-item">
                                <a href="{{ $setting->youtube ?? '' }}" class="footer__social-list-item-lisk">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom-wrapper">
        <div class="container">
            <p class="footer__bottom-text">
                © {{ date('Y') }}, All rights reserved
                <strong class="text-brand" style="color: cornflowerblue">{{env('APP_NAME')}}</strong> |
                Designed & Developed by
                <a href="https://webcare-it.com/" target="_blank" rel="noopener noreferrer" class="text-brand fw-bold" style="color: cornflowerblue">Webcare IT</a>
            </p>
        </div>
    </div>
</footer>
