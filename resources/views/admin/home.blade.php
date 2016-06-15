@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a class="btn btn-primary btn-lg margin-right-md" role="button" href="{{ URL::route('admin.casino.create') }}">
                        <span class="glyphicon glyphicon-plus-sign" style="font-size: 1.5em"></span>
                        <br>
                        Add Casinos
                    </a>
                    <a class="btn btn-default btn-lg" role="button" href="{{ URL::route('admin.casino.index') }}">
                        <span class="glyphicon glyphicon-eye-open" style="font-size: 1.5em"></span>
                        <br>
                        View Casinos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
