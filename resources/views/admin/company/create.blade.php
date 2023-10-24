@extends('dashboard.layout.master')

@section('style')
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
@endsection

@section('content')
    <x-loader />
    <section class="content">
        <div class="col-md-12 mx-auto pt-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        @if (isset($company))
                            Edit
                        @else
                            Create
                        @endif
                        Company
                    </h3>
                </div>
                @if (isset($company))
                    <form method="post" action="{{ route('admin.company.update', ['company' => $company->id]) }}"
                        id="companyRegister">
                        @method('patch')
                    @else
                        <form method="post" action="{{ route('admin.company.store') }}" id="companyRegister">
                            @method('post')
                @endif
                @csrf

                <div class="col-md-12 mt-3">

                    <div class="form-group">
                        <label class="form-label fw-bold" for="name">Name<span class="text-danger ms-1">*</span></label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ isset($company) ? $company->name : '' }}" placeholder="Bolton and Green Trading" />
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email" class="form-label fw-bold">E-mail<span
                                class="text-danger ms-1">*</span></label>
                        <input type="email" class="form-control " id="email" name="email"
                            value="{{ isset($company) ? $company->email : '' }}" placeholder="xyz@gmail.com" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="number" class="form-label fw-bold">Mobile<span
                                class="text-danger ms-1">*</span></label>
                        <input type="number" class="form-control " id="number" name="number"
                            value="{{ isset($company) ? $company->number : '' }}" placeholder="7410852000" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address" class="form-label fw-bold">Address<span
                                class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control " id="address" name="address"
                            value="{{ isset($company) ? $company->address : '' }}"
                            placeholder="Enter your company address." />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address" class="form-label fw-bold">City<span class="text-danger ms-1">*</span></label>
                        <select name="city_id" class="form-control" style="appearance: auto">
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}"
                                    {{ isset($company) && $company->city_id == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit"
                        class="btn btn-primary ms-2 ">{{ isset($company) ? 'Update' : 'Submit' }}</button>

                    <a href="{{ route('admin.company.index') }}" class="btn btn-outline-secondary my-0">Back</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            function store(form) {
                $.ajax({
                    url: $(form).attr("action"),
                    type: $(form).attr("method"),
                    data: $(form).serialize(),
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
                        var message = response.message;
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                        }
                        toastr.error(message);
                    },
                });
            }

            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+( [a-zA-Z0-9]+)*$/.test(value);
            }, "Letters and numbers only with a single space between words.");

            $.validator.addMethod("validNumber", function(value, element) {
                return !/0{10}/.test(value);
            }, "{{ __('validation.valid', ['attribute' => 'mobile']) }}");

            $("#companyRegister").validate({
                errorClass: "text-danger font-weight-normal",
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        lettersonly: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    number: {
                        required: true,
                        number: true,
                        validNumber: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    address: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    }
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
                    number: {
                        required: "{{ __('validation.required', ['attribute' => 'mobile']) }}",
                        number: "{{ __('validation.valid', ['attribute' => 'mobile']) }}",
                        digits: "The number must be a 10 digits",
                        minlength: "{{ __('validation.min_digits', ['attribute' => 'mobile', 'min' => '10']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'mobile', 'max' => '10']) }}",
                    },
                    address: {
                        required: "{{ __('validation.required', ['attribute' => 'address']) }}",
                    },
                },
                submitHandler: function(form) {
                    $(".loader-container").fadeIn();
                    store(form);
                },
            });
        });
    </script>
@endsection
