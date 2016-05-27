@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>All Casinos</h1>
            @if($casinos->isEmpty())
                <div class="alert alert-warning" role="alert">
                    <strong>No casinos added!</strong>
                    You'll want to <a href="{{ URL::route('admin.casino.create') }}" class="alert-link">add a casino</a> first.
                </div>
            @else
                @foreach($casinos as $casino)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $casino->name }}
                        </div>

                        <div class="panel-body">
                            {{ $casino->description or 'No description added' }}
                        </div>

                        <div class="panel-footer">
                            <a class="btn btn-default" href="{{ URL::route('admin.casino.show', $casino->id) }}" role="button">View</a>
                            <a class="btn btn-primary" href="{{ URL::route('admin.casino.edit', $casino->id) }}" role="button">Edit</a>
                            <a class="btn btn-danger" href="{{ URL::route('admin.casino.destroy', $casino->id) }}" role="button">Delete</a>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>
@endsection
