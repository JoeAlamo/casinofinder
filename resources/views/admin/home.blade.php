@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a class="btn btn-primary" href="{{ URL::route('admin.casino.create') }}" role="button">Add Casinos</a>
                    <a class="btn btn-default" href="{{ URL::route('admin.casino.index') }}" role="button">View Casinos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
