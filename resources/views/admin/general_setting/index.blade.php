@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{url('/settings/update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Phone <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="phone" value="{{$general_setting->phone}}" class="form-control" placeholder="Enter phone"><br>
                                                    <span style="color: red"> {{ $errors->has('phone') ? $errors->first('phone') : ' ' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Email <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="email" name="email" value="{{$general_setting->email}}" class="form-control" placeholder="Enter email"><br>
                                                    <span style="color: red"> {{ $errors->has('email') ? $errors->first('email') : ' ' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Facebook <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="facebook" value="{{$general_setting->facebook}}" class="form-control" placeholder="Enter facebook"><br>
                                                    <span style="color: red"> {{ $errors->has('facebook') ? $errors->first('facebook') : ' ' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Instagram <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="instagram" value="{{$general_setting->instagram}}" class="form-control" placeholder="Enter instagram"><br>
                                                    <span style="color: red"> {{ $errors->has('instagram') ? $errors->first('instagram') : ' ' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Youtube <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="youtube" value="{{$general_setting->youtube}}" class="form-control" placeholder="Enter youtube"><br>
                                                    <span style="color: red"> {{ $errors->has('youtube') ? $errors->first('youtube') : ' ' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Twitter <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="twitter" value="{{$general_setting->twitter}}" class="form-control" placeholder="Enter twitter"><br>
                                                    <span style="color: red"> {{ $errors->has('twitter') ? $errors->first('twitter') : ' ' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Logo <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="file" name="logo" id="logo" class="form-control"><br>
                                                    <span style="color: red"> {{ $errors->has('logo') ? $errors->first('logo') : ' ' }}</span>
                                                </div>
                                                <img src="{{asset('setting/'.$general_setting->logo)}}" height="100" width="100" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Address <small style="color: red; font-size: 18px;">*</small></label>
                                                <textarea class="form-control" rows="5" name="address">{!!$general_setting->address!!}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('address') ? $errors->first('address') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <hr style="margin: 20px 0;">
                                        <div class="col-md-12">
                                            <h5 style="margin-bottom: 20px; font-weight: 600;">Droploo API Credentials</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Droploo App Key</label>
                                                <input type="text" name="droploo_app_key" value="{{$general_setting->droploo_app_key ?? ''}}" class="form-control" placeholder="Enter Droploo App Key"><br>
                                                <span style="color: red"> {{ $errors->has('droploo_app_key') ? $errors->first('droploo_app_key') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Droploo App Secret</label>
                                                <input type="text" name="droploo_app_secret" value="{{$general_setting->droploo_app_secret ?? ''}}" class="form-control" placeholder="Enter Droploo App Secret"><br>
                                                <span style="color: red"> {{ $errors->has('droploo_app_secret') ? $errors->first('droploo_app_secret') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Droploo Username</label>
                                                <input type="text" name="droploo_username" value="{{$general_setting->droploo_username ?? ''}}" class="form-control" placeholder="Enter Droploo Username"><br>
                                                <span style="color: red"> {{ $errors->has('droploo_username') ? $errors->first('droploo_username') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <hr style="margin: 20px 0;">
                                        <div class="col-md-12">
                                            <h5 style="margin-bottom: 20px; font-weight: 600;">Steadfast Courier API Credentials</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Steadfast API Key</label>
                                                <input type="text" name="steadfast_api_key" value="{{$general_setting->steadfast_api_key ?? ''}}" class="form-control" placeholder="Enter Steadfast API Key"><br>
                                                <span style="color: red"> {{ $errors->has('steadfast_api_key') ? $errors->first('steadfast_api_key') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Steadfast Secret Key</label>
                                                <input type="text" name="steadfast_secret_key" value="{{$general_setting->steadfast_secret_key ?? ''}}" class="form-control" placeholder="Enter Steadfast Secret Key"><br>
                                                <span style="color: red"> {{ $errors->has('steadfast_secret_key') ? $errors->first('steadfast_secret_key') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <hr style="margin: 20px 0;">
                                        <div class="col-md-12">
                                            <h5 style="margin-bottom: 20px; font-weight: 600;">Website Theme Colors</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Primary Color</label>
                                                <input type="color" name="primary_color" value="{{$general_setting->primary_color ?? '#053C6B'}}" class="form-control form-control-color" style="height: 45px;" title="Choose primary color"><br>
                                                <small class="text-muted">Main brand color used throughout the website</small>
                                                <span style="color: red"> {{ $errors->has('primary_color') ? $errors->first('primary_color') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Secondary Color</label>
                                                <input type="color" name="secondary_color" value="{{$general_setting->secondary_color ?? '#333333'}}" class="form-control form-control-color" style="height: 45px;" title="Choose secondary color"><br>
                                                <small class="text-muted">Used for secondary elements</small>
                                                <span style="color: red"> {{ $errors->has('secondary_color') ? $errors->first('secondary_color') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Accent Color</label>
                                                <input type="color" name="accent_color" value="{{$general_setting->accent_color ?? '#f41127'}}" class="form-control form-control-color" style="height: 45px;" title="Choose accent color"><br>
                                                <small class="text-muted">Used for highlights and accents</small>
                                                <span style="color: red"> {{ $errors->has('accent_color') ? $errors->first('accent_color') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Category Background Color</label>
                                                <input type="color" name="category_bg_color" value="{{$general_setting->category_bg_color ?? '#053C6B'}}" class="form-control form-control-color" style="height: 45px;" title="Choose category background color"><br>
                                                <small class="text-muted">Background color for category sections</small>
                                                <span style="color: red"> {{ $errors->has('category_bg_color') ? $errors->first('category_bg_color') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Header Background Color</label>
                                                <input type="color" name="header_bg_color" value="{{$general_setting->header_bg_color ?? '#ffffff'}}" class="form-control form-control-color" style="height: 45px;" title="Choose header background color"><br>
                                                <small class="text-muted">Background color for header</small>
                                                <span style="color: red"> {{ $errors->has('header_bg_color') ? $errors->first('header_bg_color') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Footer Background Color</label>
                                                <input type="color" name="footer_bg_color" value="{{$general_setting->footer_bg_color ?? '#333333'}}" class="form-control form-control-color" style="height: 45px;" title="Choose footer background color"><br>
                                                <small class="text-muted">Background color for footer</small>
                                                <span style="color: red"> {{ $errors->has('footer_bg_color') ? $errors->first('footer_bg_color') : ' ' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
    <script>
        $('#addMore').click(function(){
            let html = '';
            html+='<div class="input-group mb-3" id="removeRow">'
                html+='<input type="file" name="gallery_image[]" id="gallery_image" class="form-control">'
                html+='<button class="btn btn-sm btn-danger" type="button" id="remove">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#remove', function () {
            $(this).closest('#removeRow').remove();
        });

        $('#addMoreSize').click(function(){
            let html = '';
            html+='<div class="input-group mb-3" id="removeSizeRow">'
                html+='<input type="text" name="size[]" id="size" class="form-control" placeholder="Product size">'
                html+='<button class="btn btn-sm btn-danger" type="button" id="removeSize">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRowForSize').append(html);
        });

        // remove row
        $(document).on('click', '#removeSize', function () {
            $(this).closest('#removeSizeRow').remove();
        });

        $('#addMoreColor').click(function(){
            let html = '';
            html+='<div class="input-group mb-3" id="removeColorRow">'
                html+='<input type="text" name="color[]" id="color" class="form-control" placeholder="Product color">'
                html+='<button class="btn btn-sm btn-danger" type="button" id="removeColor">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRowForColor').append(html);
        });

        // remove row
        $(document).on('click', '#removeColor', function () {
            $(this).closest('#removeColorRow').remove();
        });
    </script>
@endpush
