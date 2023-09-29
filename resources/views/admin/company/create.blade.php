@extends('dashboard.layout.dashboard_layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('asset/css/loader.css') }}">
@endsection

@section('content')
    <x-loader />
    <section class="content">
        <div class="col-md-10 mx-auto pt-3">
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
                        <label class="form-label fw-bold" for="name">Company Name<span
                                class="text-danger ms-1">*</span></label>
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

            $("#companyRegister").validate({
                errorClass: "text-danger font-weight-normal",
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    number: {
                        required: true,
                        number: true,
                        digits: 10
                    },
                    address: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter company name.",
                    },
                    email: {
                        required: "Please enter company email.",
                        email: "Please enter a valid email address.",
                    },
                    number: {
                        required: "Please enter company mobile number.",
                        number: "Please enter a valid number",
                        digits: "The number must have exactly 10 digits"
                    },
                    address: {
                        required: "Please enter company address.",
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
