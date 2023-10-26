@extends('front.layout.layout')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('asset/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
    <style>
        #login {
            color: black;
        }

        #login:hover {
            color: #51B56D;
        }

        .form-label {
            margin-bottom: 0.5rem;
            color: #000;
        }

        .form-control:not(textarea) {
            height: 50px;
        }

        textarea.form-control {
            height: 80px !important;
        }

        .form-group .label-filed {
            z-index: 1;
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

            <div class="form-group mb-4">
                <label for="company_id" class="form-label label-filed">Company</label>
                <select class="form-control" value="{{ old('company_id') }}" name="company_id" id='company_id'
                    style="appearance: revert;padding-right: 65px;">
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4 " style="flex-grow: 1;">
                <label for="mobile" class="form-label label-filed">Mobile</label>
                <input type="number" value="{{ old('mobile') }}" class="form-control shadow-none" name="mobile"
                    id="mobile">
            </div>

            <div class="form-group col-span-6 mb-4" style="width: 100%;">
                <label for="profile_img" class="form-label label-filed">{{ __('messages.form.img') }}</label>
                <div class="custom-file ">
                    <input name="avatar" type="file" id="profile_img" class="dropify" data-height="100" />
                </div>
            </div>

            <div class="d-flex align-items-center mb-3">
                <button class="btn btn-primary w-25 " id="issueSubmit" type="submit">Submit</button>
                <a href="{{ route('login') }}" id="login" style="text-decoration: none;" class="ms-3">Already have an
                    Account?</a>
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
            }, "{{ __('validation.valueNotEquals', ['attribute' => 'company']) }}");

            $.validator.addMethod("filesize", function(value, element, param) {
                var fileSize = element.files[0].size; // Get the file size in bytes
                return fileSize <= param;
            });

            $.validator.addMethod("pattern", function(value, element) {
                    return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test(value);
                },
                "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character."
            );

            $.validator.addMethod("validNumber", function(value, element) {
                return !/0{10}/.test(value);
            }, "{{ __('validation.valid', ['attribute' => 'mobile']) }}");

            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
            }, "Please enter letters only (no special characters or numbers).");


            $("#hrRegister").validate({
                errorClass: "text-danger fw-normal",
                rules: {
                    name: {
                        required: true,
                        lettersonly: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        pattern: true,
                        minlength: 8,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    company_id: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                        number: true,
                        validNumber: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                },
                messages: {
                    name: {
                        required: "{{ __('validation.required', ['attribute' => 'name']) }}",
                    },
                    email: {
                        required: "{{ __('validation.required', ['attribute' => 'email']) }}",
                        email: "{{ __('validation.email', ['attribute' => 'email']) }}",
                    },
                    password: {
                        required: "{{ __('validation.required', ['attribute' => 'password']) }}",
                        minlength: "{{ __('validation.min.string', ['attribute' => 'password', 'min' => '8']) }}",
                        pattern: "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.",
                    },
                    password_confirmation: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords does not match.",
                    },
                    company_id: {
                        required: "{{ __('validation.required', ['attribute' => 'company']) }}",
                    },
                    number: {
                        required: "{{ __('validation.required', ['attribute' => 'number']) }}",
                        number: "{{ __('validation.valid', ['attribute' => 'number']) }}",
                        digits: "The number must be a 10 digits",
                        minlength: "{{ __('validation.min_digits', ['attribute' => 'number', 'min' => '10']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'number', 'max' => '10']) }}",
                    },
                },
                submitHandler: function(form) {
                    $('#issueSubmit').prop("disabled", true);
                    $(".loader-container").fadeIn();
                    let formData = new FormData(form);
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $(".loader-container").fadeOut();
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.success(response.success);
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.hr.index') }}";
                            }, 2000);
                            $('#issueSubmit').prop("disabled", false);
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
