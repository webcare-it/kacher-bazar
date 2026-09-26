<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <!-- Boostrap-5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            /*login section css start*/
            .login-section {
                padding: 40px 0px;
            }

            .login-form {
                display: flex;
                flex-wrap: wrap;
                box-shadow: 0 0 10px #cccccc;
                width: auto;
                background: #ffffff;
                border-radius: 5px;
                padding: 50px 30px;
                overflow: hidden;
                position: relative;
            }
            .login-custom {
                border-left: 1px solid #e7e7e7;
                padding-left: 30px;
            }
            .login-custom.supplier {
                border-left: none;
            }

            .login-custom h4 {
                font-size: 15px;
                font-family: 'Poppins';
                font-weight: 600;
                margin-bottom: 25px;
                color: #154360;
                text-transform: capitalize;
                text-align: center;
            }
            .placeorder-btn-inner {
                text-align: center;
                margin-top: 20px;
            }
            .placeorder-btn {
                display: inline-block;
                background: #f16522;
                color: #fff;
                padding: 7px 40px;
                font-size: 16px;
                font-family: 'Poppins';
                font-weight: 400;
                text-transform: capitalize;
                border-radius: 5px;
            }

            .login-custom input {
                border: 1px solid #e7e7e7;
                box-shadow: inherit;
                height: 50px;
                padding: 6px 14px;
                font-size: 14px;
                border-radius: 5px;
            }

            .login-custom .row {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .login-custom label {
                display: flex;
                margin-bottom: 5px;
                font-family: 'Poppins';
                font-weight: 400;
                align-items: center;
                float: left;
                color: #333339;
            }

            .login-custom label input {
                float: left;
                margin-right: 5px;
                height: 20px;
            }

            .customer-register-btn-wrapper {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .customer-login-btn-link {
                display: block;
                background: #154360;
                padding: 7px 20px;
                color: #fff;
                font-size: 16px;
                font-family: 'Poppins';
                text-transform: capitalize;
                font-weight: 500;
                border-radius: 5px;
            }

            .customer-login-btn-link:hover {
                color: #fff;
            }
            .left-customer-btn-outer {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .left-customer-btn-outer ul {
                display: flex;
                align-items: center;
                justify-content: center;
                padding-left: 0;
                margin-bottom: 0;
            }
            .left-customer-btn-outer ul li a {
                display: inline-block;
                background: #002147;
                color: #ffffff;
                font-size: 16px;
                height: 40px;
                width: 40px;
                line-height: 40px;
                text-align: center;
                border-radius: 100%;
            }
            .left-customer-btn-outer ul li.facebook {
                margin: 0 10px;
            }
            .left-customer-btn-outer ul li.twitter a {
                background: #1da1f2;
            }
            .left-customer-btn-outer ul li a:hover {
                transform: rotate(360deg);
            }
            .lost-pass-link {
                display: inline-block;
                text-align: right;
                color: #002147;
                font-size: 16px;
                font-family: 'Poppins';
                font-weight: 400;
            }

            .lost-pass-link:hover {
                color: #154360;
            }

            .login-custom button {
                display: inline-block;
                border: medium;
                background: #fd0fbd;
                font-size: 18px;
                color: #fff;
                font-family: 'Poppins';
                padding: 8px 50px;
                font-weight: 900;
                text-transform: capitalize;
                margin-top: 10px;
                border-radius: 5px;
            }

            .login-custom button:focus {
                outline: none;
            }

            .forgot-password {
                padding: 8px 16px;
                word-spacing: 4px;
            }

            .link-bottom {
                margin-bottom: 0;
                margin-top: 15px;
                display: block;
                width: 100%;
                float: left;
                color: #666666;
                font-weight: 400;
            }

            .link-bottom a {
                color: #002147;
                font-size: 16px;
                font-family: 'Poppins';
                font-weight: 400;
            }

            .link-bottom a:hover {
                color: #154360;
            }
            /*login section css End*/
        </style>
    </head>
    <body>
        <section class="login-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 m-auto">
                        <form id="login-form" action="{{url('/login')}}" method="post" class="login-form">
                            @csrf
                            <div class="col-md-12 m-auto login-custom supplier">
                                <h4>Login to your registered account!</h4>
                                <div class="col-md-12 form-group mb-3">
                                    <input type="email" name="email" placeholder="Email*" class="form-control @error('email') is-invalid @enderror" required="" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <input type="password" name="password" placeholder="Password*" class="form-control @error('password') is-invalid @enderror" required="" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
        
                                <div class="col-md-12 px-0">
                                    <button type="submit">
                                        Login
                                    </button>
                                </div>
                                <p class="link-bottom">
                                    Not a member yet?
                                    <a href="{{url('/customer/register-form')}}">Register Now</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>        
    </body>
</html>
