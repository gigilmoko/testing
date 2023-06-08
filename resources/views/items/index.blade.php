@extends('layouts.master')

@section('content')
<div class="m-4">
    <div class="container-fluid container-lg">
    <div class="modal" tabindex="-1" role="dialog" id="createItem">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Add customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h1 class="mb-5">Laravel 9 with Yajra Datatables</h1>

        {{$dataTable->table()}}
        {{$dataTable->scripts()}}

    </div>
</div>
</div>
@endsection
