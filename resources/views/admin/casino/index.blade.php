@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>All Casinos</h1>

            <div id="no-casino-alert" class="alert alert-warning hidden" role="alert">
                <strong>No casinos added!</strong>
                You'll want to <a href="{{ URL::route('admin.casino.create') }}" class="alert-link">add a casino</a> first.
            </div>

            @foreach($casinos as $casino)
                <div class="panel panel-default casino-panel">
                    <div class="panel-heading">
                        {{ $casino->name }}
                    </div>

                    <div class="panel-body">
                        @if($casino->description)
                            {{ $casino->description }}
                        @else
                            <p>No description added!</p>
                        @endif
                    </div>

                    <div class="panel-footer">
                        <a class="btn btn-default" href="{{ URL::route('admin.casino.show', $casino->id) }}" role="button">View</a>
                        <a class="btn btn-primary" href="{{ URL::route('admin.casino.edit', $casino->id) }}" role="button">Edit</a>
                        <button class="btn btn-danger" data-url="{{ URL::route('admin.casino.destroy', $casino->id) }}" data-toggle="modal" data-target="#delete-casino-modal" role="button">Delete</button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<div class="modal fade" id="delete-casino-modal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="delete-casino-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['route' => ['admin.casino.destroy', 0], 'id' => 'delete-casino-form', 'method' => 'DELETE']) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="delete-casino-modal-label">Confirm you wish to delete the casino</h4>
            </div>
            <div class="modal-body">
                <p class="text-center"><strong>Are you sure you wish to delete this casino?</strong></p>
            </div>
            <div class="modal-footer">
                {{ Form::submit("Delete Casino", array("class" => "btn btn-success btn-block", "id" => "delete-casino-submit")) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    {!! HTML::script('/assets/js/admin/casino/deleteCasino.js') !!}
@append
