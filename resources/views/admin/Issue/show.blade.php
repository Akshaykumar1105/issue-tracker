@extends('dashboard.layout.master')
@section('style')
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endsection
@section('content')
    <section class="content pt-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="fw-bold">Issue Details</h4>
                        <hr>
                        <div class="form-group">
                            <label class="fw-bold" for="title">Title</label>
                            <p>{{ $issue->title }}</p>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold" for="description">Description</label>
                            <p>{{ $issue->description }}</p>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold" for="priority">Priority</label>
                            <p>{{ $issue->priority }}</p>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold" for="company">Company Name</label>
                            <p>{{ $issue->company->name }}</p>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold" for="hr">Hr Name</label>
                            <p>{{ $issue->hr->name }}</p>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold" for="assign">Assign To</label>
                            @if ($issue->manager_id == null)
                                <p>Not assigned to a manager.</p>
                            @else
                                <p>{{ $issue->manager->name }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="fw-bold" for="status">Status</label>
                            @if ($issue->status == null)
                                <p>Not selected a status.</p>
                            @else
                                <p>{{ str_replace('_', ' ', ucwords(strtolower($issue->status))) }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="fw-bold">Due Date</label>
                            @if ($issue->due_date == null)
                                <p>Not selected a due date.</p>
                            @else
                                <p>{{ $issue->due_date }}</p>
                            @endif
                        </div>
                        <a href="{{ $route }}" id="back" class="btn btn-primary mt-3">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Your custom JavaScript file
        $(document).ready(function() {
            $('#back').click(function() {
                window.history.back();
            });

        });
    </script>
@endsection
