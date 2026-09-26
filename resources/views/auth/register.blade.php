{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register' .$url) }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<html>
    <head>
        <title>Registration</title>
        <!-- Boostrap-5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            /*Registation section css start*/
            .registation-section {
                padding: 40px 0;
            }
            #regForm {
                background: #fff;
                border-radius: 10px;
                padding: 40px 30px;
                box-shadow: -3px -3px 7px #ffffff73, 0px 2px 20px rgb(94 104 121 / 34%);
            }
            #regForm h1 {
                text-align: center;
                font-size: 28px;
                font-family: 'Poppins';
                font-weight: 500;
                margin-bottom: 25px;
                color: #154360;
            }
            .supplier-logo-input input {
                margin-bottom: 0!important;
            }
            .supplier-logo-input label {
                position: absolute;
                top: 50%;
                left: 10px;
                transform: translateY(-50%);
                background: #efefef;
                margin-bottom: 0;
                padding: 6px 10px;
                text-align: center;
                width: 100px;
                height: 34px;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 5px;
                font-size: 15px;
                box-shadow: 0px 0px 2px #00000036;
                cursor: pointer;
                transition: all .3s ease;
            }
            .supplier-logo-input label:hover {
                box-shadow: 0px 0px 6px #00000040;
            }
            .supplier-logo-input {
                position: relative;
                margin-bottom: 15px;
            }
            #regForm input {
                padding: 10px;
                width: 100%;
                font-size: 17px;
                font-family: Raleway;
                border: 1px solid #aaaaaa;
                margin-bottom: 15px;
                border-radius: 5px;
            }
            #regForm input:focus {
                outline: none;
            }
            .registation-form-btn {
                border: 1px solid #fd0fbd;
                background: #fd0fbd;
                font-size: 20px;
                text-transform: capitalize;
                color: #fff;
                font-weight: 900;
                padding: 8px 50px;
                margin-top: 20px;
                border-radius: 30px;
            }
            .sign-up-link {
                display: inline-block;
                text-align: center;
                margin-top: 20px;
                font-size: 18px;
                font-weight: 800;
                color: #fd0fbd;
                text-decoration: underline;
            }
            /*Registation section css End*/
        </style>
    </head>
    <body>
        <section class="registation-section">
            <div class="container">                            
                <div class="row">
                    <div class="col-lg-6 col-md-12 m-auto">
                        <form id="regForm" action="{{ route('user.register') }}" method="post" enctype="multipart/form-data">   
                            @csrf             
                            <h1>User Registation</h1>
                            <!-- One "tab" for each step in the form: -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-item-wrapper">
                                        <input type="text" placeholder="Name..." name="name" class="@error('name') is-invalid @enderror">
                                        <span style="color: red">  </span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-item-wrapper">
                                        <input type="email" placeholder="E-mail..." name="email" class="@error('email') is-invalid @enderror">
                                        <span style="color: red">  </span>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-item-wrapper">
                                        <input type="text" placeholder="Address..." name="address">
                                        <span style="color: red">  </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-item-wrapper">
                                        <input type="password" placeholder="Password..." name="password" class="@error('password') is-invalid @enderror">
                                        <span style="color: red">  </span>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>       
                                <div class="col-md-12">
                                    <div class="input-item-wrapper">
                                        <input id="password-confirm" type="password" placeholder="Confirm Password..." name="password_confirmation" required autocomplete="new-password">
                                        <span style="color: red">  </span>
                                    </div>
                                </div>                           
                            </div>
                            <div class="text-center">
                                <button type="submit" class="registation-form-btn">Submit</button>
                            </div>
                            <div class="text-center">
                                <a href="{{url('/login')}}" class="sign-up-link">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>