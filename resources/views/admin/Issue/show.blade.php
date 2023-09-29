@extends('dashboard.layout.dashboard_layout')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endsection
@section('content')
    <section class="content pt-3">
        {{-- {{$issue}} --}}
        <!-- Default box -->
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">Issue Detail</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 ">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="name">Title</label>
                                <p>{{ $issue->title }}</p>
                            </div>

                            <div class="col-md-12 ">
                                <label class="form-label fw-bold" for="name">Description</label>
                                <p class="">{{ $issue->description }}</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="email" class="form-label fw-bold">Priority</label>
                                <p class="my-0">{{ $issue->priority }}</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="email" class="form-label fw-bold">Assign To</label>
                                @if ($issue->manager_id == null)
                                    <p class="my-0">Not assign manager.</p>
                                @else
                                    <p class="my-0">{{ $issue->user->name }}</p>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email" class="form-label fw-bold">Status</label>
                                @if ($issue->status == null)
                                    <p class="my-0">Not select status.</p>
                                @else
                                    <p class="my-0">{{ $issue->status }}</p>
                                @endif
                            </div>

                            <div class="form-group col-md-12">
                                <label class="d-block font-weight-bold">Due Date</label>
                                @if ($issue->due_date == null)
                                    <p class="my-0">Not select due date.</p>
                                @else
                                    <p class="my-0">{{ $issue->due_date }}</p>
                                @endif
                            </div>
                            <a href="{{ $route }}" id="back" style="width:100px;"
                                class="btn btn-primary ms-2 mb-2">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card-body -->

        <!-- /.card -->




    </section>
@endsection

@section('script')
    <script>
        // Your custom JavaScript file
        $(document).ready(function() {
            $('#back').click(function() {
                // Go back to the previous page
                window.history.back();
                // Reload the page
                // location.reload();
            });

        });

    </script>
@endsection
