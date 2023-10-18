@extends('dashboard.layout.dashboard_layout')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/dropify.min.css') }}">
@endsection
@section('content')
    <x-loader />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-11 mx-auto mt-3">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            @if (Request::is('admin/manager/*'))
                                @if (isset($user))
                                    <h3 class="card-title">{{ __('messages.manager.edit') }}</h3>
                                @else
                                    <h3 class="card-title">{{ __('messages.manager.register') }}</h3>
                                @endif
                            @else
                                @if (isset($user))
                                    <h3 class="card-title">Edit Hr</h3>
                                @else
                                    <h3 class="card-title">Create Hr</h3>
                                @endif
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (Request::is('admin/manager/*'))
                            @if (isset($user))
                                <form method='post' id="createUser"
                                    action="{{ route('admin.manager.update', ['manager' => $user->id]) }}"
                                    enctype="multipart/form-data">
                                    @method('patch')
                                @else
                                    <form method='post' id="createUser" action="{{ route('admin.manager.store') }}"
                                        enctype="multipart/form-data">
                            @endif
                        @else
                            @if (isset($user))
                                <form method='post' id="createUser"
                                    action="{{ route('admin.hr.update', ['hr' => $user->id]) }}"
                                    enctype="multipart/form-data">
                                    @method('patch')
                                @else
                                    <form method='post' id="createUser" action="{{ route('admin.hr.store') }}"
                                        enctype="multipart/form-data">
                            @endif
                        @endif

                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter your manager name." value="{{ isset($user) ? $user->name : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email </label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Enter your manager email" value="{{ isset($user) ? $user->email : '' }}">
                            </div>

                            <div class="form-group mb-4">
                                <label for="company_id" class="form-label">Company</label>
                                <select class="form-control" value="{{ old('company_id') }}" name="company_id"
                                    id='company_id' style="width: 300px;appearance: revert;padding-right: 65px;">
                                    <option value="default">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ isset($user) && $user->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if (Route::currentRouteName() == 'admin.manager.create')
                                <div class="form-group mb-4">
                                    <label class="form-label">Hr</label>
                                    <select id="selectHr" name="hr_id" class="form-control"
                                        style="width: 300px;appearance: revert;padding-right: 65px;">
                                        <option value="">Select Hr</option>
                                    </select>
                                </div>
                            @else
                            @endif
                            @if (!isset($user))
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" autocomplete="new-password">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" placeholder="Password confirmation"
                                        autocomplete="new-password">
                                </div>
                            @endif
                            <div class="form-group mb-4 ">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="number" value="{{ isset($user) ? $user->mobile : '' }}"
                                    class="form-control shadow-none" name="mobile" id="mobile" placeholder="7410852000">
                            </div>

                            <div class="form-group " style=";font-size: 20px;">
                                <label for="profile_img" class="form-label">{{ __('messages.form.img') }}</label>
                                <div class="custom-file ">
                                    <input name="profile_img" type="file" id="profile_img" class="dropify"
                                        data-height="100"
                                        @if (isset($user)) data-default-file="{{ asset('storage/user/' . $user->getMedia('user')->first()->filename . '.' . $user->getMedia('user')->first()->extension) }}"
                                        @else
                                        data-default-file="" @endif />
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit"
                                class="btn btn-primary">{{ isset($user) ? 'Update' : 'Submit' }}</button>
                            @if (Route::currentRouteName() == 'admin.hr.edit' || Route::currentRouteName() == 'admin.hr.create')
                                <a class="btn btn-outline-secondary" href="{{ route('admin.hr.index') }}">
                                    Back
                                </a>
                            @else
                                <a class="btn btn-outline-secondary" href="{{ route('admin.manager.index') }}">
                                    Back
                                </a>
                            @endif
                        </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>


    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/jquery-datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatable.min.js') }}"></script>
    <script src="{{ asset('asset/js/dropify.min.js') }}"></script>

    <script>
        // Your custom JavaScript file
        $(document).ready(function() {
            $('.dropify').dropify();

            let currentRoute = "{{ Route::currentRouteName() }}";

            if (currentRoute == 'admin.manager.create') {
                $(document).on('change', '#company_id', function() {
                    companyId = $(this).val();
                    $.ajax({
                        url: "{{ route('admin.manager.create') }}",
                        type: 'get',
                        data: {
                            company: companyId
                        },
                        success: function(response) {
                            let option;
                            var hrSelect = $('#selectHr');

                            if (response !== null) {
                                $.each(response, function(index, user) {
                                    option += '<option value=' + user.id + '>' + user
                                        .name + '</option>';
                                });

                                // Set the HTML of the hrSelect element
                                hrSelect.html(option);
                            } else {
                                option +=
                                    '<option value=>No users found for this company.</option>';
                                hrSelect.html(option);
                            }
                        }
                    });
                })
            }

            $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                return arg !== value;
            }, "{{ __('validation.valueNotEquals', ['attribute' => 'Company']) }}");

            $.validator.addMethod("lettersonly", function(value, element) {
                if (/^\s+|\s+$/.test(value)) {
                    return false;
                }
                if (/ {2,}/.test(value)) {
                    return false;
                }
                return /^[a-zA-Z\s]+$/i.test(value);
            }, "Please enter letters without extra spaces.");

            $.validator.addMethod("pattern", function(value, element) {
                    return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test(
                        value);
                },
                "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character."
            );

            $("#createUser").validate({
                errorClass: "text-danger fw-normal",
                rules: {
                    name: {
                        required: true,
                        lettersonly: true,
                        maxlength: 255,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        pattern: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    company_id: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    hr_id: {
                        required: true,
                        valueNotEquals: "defaultHr"
                    },
                    mobile: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true
                    },

                },
                messages: {
                    name: {
                        required: "{{ __('validation.required', ['attribute' => 'name']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'name', 'max' => '255']) }}",
                    },
                    email: {
                        required: "{{ __('validation.required', ['attribute' => 'email']) }}",
                        email: "{{ __('validation.valid', ['attribute' => 'email']) }}",
                    },
                    password: {
                        required: "{{ __('validation.required', ['attribute' => 'password']) }}",
                        minlength: "{{ __('validation.min.string', ['attribute' => 'password', 'min' => '8']) }}",
                        pattern: "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.",
                    },
                    password_confirmation: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match.",
                    },
                    company_id: {
                        required: true,
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
                                window.location.href =
                                    "{{ route('admin.hr.index') }}";
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            $(".loader-container").fadeOut();
                            var response = JSON.parse(xhr.responseText);
                            var message = response.message;
                            console.log(message)
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(message);

                        },
                    })
                },
            });


        });
    </script>
@endsection
