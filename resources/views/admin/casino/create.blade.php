@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Add a Casino</h1>
            <div class="panel panel-default">
                {!! Form::open(['route' => 'admin.casino.store']) !!}
                <div class="panel-body">
                    <p>Required fields are followed by <strong><abbr title="required">*</abbr></strong>.</p>

                    <section>
                        <h2>General Info</h2>
                        <div class="form-group">
                            {!! Form::label('name', 'Name: *') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'The name of the casino']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description:') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'A description of the casino']) !!}
                        </div>
                    </section>

                    <section>
                        <h2>Location</h2>
                        <div class="form-group">
                            {!! Form::label('address_autocomplete', 'Enter an address *') !!}
                            {!! Form::text('address_autocomplete', null, ['class' => 'form-control', 'placeholder' => 'Start typing an address']) !!}
                        </div>
                        <div id="map" style="height:300px">
                            <!-- Google Maps loaded here -->
                        </div>
                        <div class="form-group">
                            {!! Form::label('address', 'Address Line: *') !!}
                            {!! Form::text('address', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'E.g. 10 Downing Street']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('city', 'City: *') !!}
                            {!! Form::text('city', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'E.g. London']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('postal_code', 'Postal Code: *') !!}
                            {!! Form::text('postal_code', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'E.g. SW1A 2AA']) !!}
                        </div>
                        {!! Form::hidden('google_maps_place_id', null, ['id' => 'google_maps_place_id']) !!}
                        {!! Form::hidden('latitude', null, ['id' => 'latitude']) !!}
                        {!! Form::hidden('longitude', null, ['id' => 'longitude']) !!}
                    </section>

                    <section>
                        <h2>Opening Times</h2>
                        <p>If an opening time extends past midnight, please add two opening and closing times.</p>
                        <p>For example, Monday 6pm until 2am is Monday 18:00 - 23:59 <strong>AND</strong> Tuesday 00:00 - 02:00.</p>

                        <div id="opening-times-list">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3">
                                    {!! Form::label('day[]', 'Day') !!}
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    {!! Form::label('open_time[]', 'Opening Time') !!}
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    {!! Form::label('close_time[]', 'Closing Time') !!}
                                </div>
                            </div>
                        </div>

                        <button id="opening-time-add" class="btn btn-primary margin-top-sm" type="button"><span class="glyphicon glyphicon-plus"></span> Add</button>

                        <!-- Template for opening time -->
                        <div class="hidden" id="opening-time-template">
                            <div class="row">
                                <div class="form-group opening-time margin-bottom-sm margin-top-sm">
                                    <div class="col-xs-12 col-sm-3">
                                        {!! Form::select('day[]', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        {!! Form::selectTime('open_time[]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        {!! Form::selectTime('close_time[]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <button class="btn btn-danger opening-time-remove" type="button"><span class="glyphicon glyphicon-remove"></span> Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>

                <div class="panel-footer">
                    {!! Form::submit(null, ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    {!! HTML::script('https://maps.googleapis.com/maps/api/js?libraries=places') !!}
    {!! HTML::script('/assets/js/admin/casino/googleMapsCreateForm.js') !!}
    {!! HTML::script('/assets/js/admin/casino/openingTimes.js') !!}
@append
