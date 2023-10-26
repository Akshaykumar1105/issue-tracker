@extends('front.layout.layout')
@section('style')
    <!-- toastr css -->
    <link rel="stylesheet" href="{{ asset('asset/css/toastr.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .form-label {
            margin-bottom: 0.5rem;
            color: #000;
        }
        .form-control:not(textarea) {
            height: 45px;
        }

        textarea.form-control {
            height: 80px !important;
        }
    </style>
@endsection
@section('content')
    <x-loader />

    <div class="w-50 mx-auto my-5">
        <h2 style="font-weight: 200;margin: 12px 0;">Generate issue</h2>
        @php
            $uuid = $companyObj->uuid;
        @endphp
        <form action="{{ route('issue.store', ['company' => ':uuid']) }}".replace(:uuid, $uuid) id="issue"
            method="post">
            @csrf
            <div class="row">
                <input type="hidden" class="form-control shadow-none" value="{{ $uuid }}" name="issueUuid"
                    id="issueUuid">
                <div class="col-lg-12 mb-4 pb-2">
                    <div class="form-group">
                        <label for="title" class="form-label">Title<span class="text-danger ms-1">*</span></label>
                        <input type="text" value="{{ old('titleIssue') }}" class="form-control shadow-none"
                            name="title" id="title" placeholder="Enter issue title.">
                    </div>
                </div>

                <div class="col-lg-12 mb-4 pb-2">
                    <div class="form-group">
                        <label for="description" class="form-label">Description<span
                                class="text-danger ms-1">*</span></label>
                        <textarea id="description" class="form-control shadow-none" value="{{ old('description') }}" name="description" id="description"
                            style="display: block;width: 100%;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;background-color: #fff;background-clip: padding-box;-webkit-appearance: none;-moz-appearance: none;appearance: none;border-radius: 0.25rem;transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;"
                            rows="4" cols="50" placeholder="Enter your issue description"></textarea>
                    </div>
                </div>
                <div class="col-lg-12 mb-4 pb-2">
                    <div class="form-group">
                        <label for="hr" class="form-label">Human Resources<span
                                class="text-danger ms-1">*</span></label>
                        <div style="position: relative;">
                            <select class="form-control" value="{{ old('company') }}" name="hr_id" id="hr">
                                <option value="">Select Human resources</option>
                                @foreach ($hrs as $hr)
                                    <option value="{{ $hr->id }}">{{ $hr->name }}</option>
                                @endforeach
                            </select>
                            <i style="position: absolute;top: 50%;right: 20px;transform: translateY(-50%);"
                                class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4 pb-2">
                    <div class="form-group">
                        <label for="email" class="form-label">E-mail<span
                                class="text-danger ms-1">*</span></label>
                        <input type="email" value="{{ old('email') }}" class="form-control shadow-none" name="email"
                            id="email" placeholder="Enter your E-mail">
                    </div>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('asset/js/validation.min.js') }}"></script>

    <!--toastr js -->
    <script src="{{ asset('asset/js/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {


            $("#issue").validate({
                errorClass: "text-danger fw-normal",
                rules: {
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    description: {
                        required: true,
                        minlength: 50
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    hr_id: {
                        required: true,
                    }
                },
                messages: {
                    hr_id: {
                        required: "{{ __('validation.required', ['attribute' => 'hr']) }}",
                        valueNotEquals: "{{ __('validation.valueNotEquals', ['attribute' => 'hr']) }}"
                    },
                    email: {
                        required: "{{ __('validation.required', ['attribute' => 'email']) }}",
                        email: "{{ __('validation.valid', ['attribute' => 'email']) }}",
                    },
                    title: {
                        required: "{{ __('validation.required', ['attribute' => 'title']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'title', 'max' => '255']) }}",
                    },
                    description: {
                        required: "{{ __('validation.required', ['attribute' => 'description']) }}",
                        minlength: "{{ __('validation.min_digits', ['attribute' => 'description', 'min' => '50']) }}",
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: $(form).serialize(),
                        success: function(response) {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.success(response.success);
                            form.reset();
                        },
                        error: function(xhr, status, error) {
                            var response = JSON.parse(xhr.responseText);
                            var message = response.message;
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
