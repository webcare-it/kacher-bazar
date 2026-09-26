<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <link rel="icon" href="{{asset('setting/'.$setting->logo)}}"/>
    <meta name="facebook-domain-verification" content="ieyemwwciplmb8zl8f4n32ghwihek7" />
    <!-- Pavicon ICon -->
    @include('frontend.v-2.includes.style')
    <!-- Dynamic Theme Colors -->
    {!! \App\Helpers\ThemeHelper::getThemeStyleTag() !!}
<!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id={{$code->gtm_id ?? 'GTM-XXXXXXX'}}'+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{$code->gtm_id ?? 'GTM-XXXXXXX'}}');
    </script>
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id={{$code->gtm_id ?? 'GTM-XXXXXXX'}}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

    @include('frontend.v-2.includes.header')

    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <!-- Home Slider -->
        @yield('content-v2')
        <!-- /Footer top -->
    </main>

    <!-- Footer -->
    @include('frontend.v-2.includes.footer')
    <!-- /Footer -->

    <!-- Jquery CDN -->
    @include('frontend.v-2.includes.script')
    @stack('script')
    {{-- <a href="https://wa.me/+88{{$setting->phone}}	" target="_blank" class="whatapps-btn-inner">
        <i class="fab fa-whatsapp"></i>
    </a> --}}
</body>

</html>
