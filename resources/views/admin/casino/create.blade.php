@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Add a Casino</h1>
            <div class="panel panel-default">
                {!! $casinoForm !!}
            </div>
        </div>
    </div>
</div>

<!-- Template for opening time -->
<div class="hidden" id="opening-time-template">
    <div class="row">
        <div class="form-group opening-time margin-bottom-sm margin-top-sm" data-key=0>
            <div class="col-xs-12 col-sm-3">
                {!! Form::select('opening_time[0][day]', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-12 col-sm-3">
                {!! Form::selectTime('opening_time[0][open_time]', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-12 col-sm-3">
                {!! Form::selectTime('opening_time[0][close_time]', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-12 col-sm-3">
                <button class="btn btn-danger opening-time-remove" type="button"><span class="glyphicon glyphicon-remove"></span> Remove</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    {!! HTML::script('https://maps.googleapis.com/maps/api/js?libraries=places') !!}
    {!! HTML::script('/assets/js/admin/casino/googleMapsCreateForm.js') !!}
    {!! HTML::script('/assets/js/formValidation/formValidation.min.js') !!}
    {!! HTML::script('/assets/js/formValidation/bootstrap.min.js') !!}
    {!! HTML::script('/assets/js/admin/casino/formValidation.js') !!}
    {!! HTML::script('/assets/js/admin/casino/openingTimes.js') !!}
@append
