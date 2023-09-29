@extends('user.layout.layout')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('asset/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
    <style>
        #login{
            color: black;
        }
        #login:hover{
            color: #51B56D;
        }
    </style>
@endsection
@section('content')
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <h2 style="font-weight: 200;margin: 12px;display: flex;justify-content: center;">Hr Registration</h2>
    <div class="w-50 mx-auto mt-5">

        <form action="{{ route('hr.register.store') }}" enctype="multipart/form-data" method="post" id="hrRegister">
            @csrf
            <div class="form-group mb-4">
                <label for="name" class="form-label label-filed">Full Name</label>
                <input type="text" value="{{ old('name') }}" class="form-control shadow-none" name="name"
                    id="name">

            </div>
            <div class="form-group mb-4 ">
                <label for="email" class="form-label label-filed">Email address</label>
                <input type="email" value="{{ old('email') }}" class="form-control shadow-none" name="email"
                    id="email">

            </div>

            <div class="form-group mb-4">
                <label for="password" class="form-label label-filed">Password</label>
                <input type="password" value="{{ old('password') }}" class="form-control shadow-none" name="password"
                    id="password">

            </div>

            <div class="form-group mb-4">
                <label for="password_confirmation" class="form-label label-filed">Confirm Password</label>
                <input type="password" value="{{ old('password_confirmation') }}" class="form-control shadow-none"
                    name="password_confirmation" id="password_confirmation">

            </div>

            <div class="d-flex justify-space-between">
                <div class="form-group mb-4">
                    <label for="company_id" class="form-label">Company</label>
                    <select class="form-control" value="{{ old('company_id') }}" name="company_id" id='company_id'
                        style="width: 300px;appearance: revert;padding-right: 65px;">
                        <option value="default">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group mb-4 ">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" value="{{ old('mobile') }}" class="form-control shadow-none" name="mobile"
                        id="mobile">
                </div>
            </div>

            {{-- <div class="form-group mb-4">
                <label for="img" class="form-label">Profile Image</label>
                <input type="file" value="{{old('img')}}" class="form-control shadow-none pt-3" name="img" id="img">
                @error('img')
                    <p class="text-danger text-sm">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="form-group col-span-6 mb-4" style="width: 50%;font-size: 20px;">
                <label for="profile_img" class="form-label">{{ __('messages.form.img') }}</label>
                <div class="custom-file ">
                    <input name="profile_img" type="file" id="profile_img" class="dropify" data-height="100" />
                </div>
            </div>

            <div class="d-flex align-items-center mb-3">
                <button class="btn btn-primary w-25 " type="submit">Submit</button>
                <a href="{{route('login')}}" id="login" style="text-decoration: none;" class="ms-3">Already have an Account?</a>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('asset/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                return arg !== value;
            }, "Please select a company from the list.");

            $.validator.addMethod("filesize", function(value, element, param) {
                var fileSize = element.files[0].size; // Get the file size in bytes
                return fileSize <= param; // Compare the file size to the maximum allowed size
            });

            $("#hrRegister").validate({
                errorClass: "text-danger",
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8, // Minimum password length
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password" // Confirm password must match password
                    },
                    company_id: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true
                    },

                },
                messages: {
                    email: {
                        required: "Please enter your email.",
                        email: "Please enter a valid email address.",
                    },
                    password: {
                        required: "Please enter your password.",
                        minlength: "Password must be at least 8 characters long."
                    },
                    password_confirmation: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match.",
                    },
                    company_id: {
                        required: "Please select an option.",
                        valueNotEquals: "Company filed is required.",
                    },
                    mobile: {
                        required: "Please enter your 10-digit mobile number.",
                        minlength: "Mobile number must be exactly 10 digits.",
                        maxlength: "Mobile number must be exactly 10 digits.",
                        digits: "Mobile number can only contain numeric digits.",
                    },

                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
                    let formData = new FormData(form);
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: formData,
                        processData: false, // Important: Don't process the data
                        contentType: false,
                        success: function(response) {
                            $(".loader-container").fadeOut();
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.success(response.success);
                            setTimeout(function() {
                                window.location.href = response.route;
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            $(".loader-container").fadeOut();
                            var response = JSON.parse(xhr.responseText);
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(response.message);
                        },
                    })
                }
            })
        });
    </script>
@endsection
