@if(isset($casino))
    {!! Form::model($casino, ['method' => 'PATCH', 'route' => ['admin.casino.update', $casino->id], 'id' => 'admin-casino-form']) !!}
@else
    {!! Form::open(['route' => 'admin.casino.store', 'id' => 'admin-casino-form']) !!}
@endif
<div class="panel-body">
    <p>Required fields are followed by <strong><abbr title="required">*</abbr></strong>.</p>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Please fix the following errors!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                    {!! Form::label('opening_time[][day]', 'Day') !!}
                </div>
                <div class="col-xs-12 col-sm-3">
                    {!! Form::label('opening_time[][open_time]', 'Opening Time') !!}
                </div>
                <div class="col-xs-12 col-sm-3">
                    {!! Form::label('opening_time[][close_time]', 'Closing Time') !!}
                </div>
            </div>

            {{-- If we are editing form, use session/flashed values if present, then fallback to model values. If creating, use session/flashed values --}}
            @if(isset($casino))
                <?php $openingTimes = old('opening_time', []) !== [] ? old('opening_time', []) : $casino->opening_time; ?>
            @else
                <?php $openingTimes = old('opening_time', []); ?>
            @endif

            @foreach($openingTimes as $key => $openingTime)
                <div class="row">
                    <div class="form-group opening-time margin-bottom-sm margin-top-sm" data-key="{{ $key }}">
                        <div class="col-xs-12 col-sm-3">
                            {!! Form::select('opening_time['.$key.'][day]', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], $openingTime['day'], ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            {!! Form::selectTime('opening_time['.$key.'][open_time]', $openingTime['open_time'], ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            {!! Form::selectTime('opening_time['.$key.'][close_time]', $openingTime['close_time'], ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            <button class="btn btn-danger opening-time-remove" type="button"><span class="glyphicon glyphicon-remove"></span> Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button id="opening-time-add" class="btn btn-primary margin-top-sm" type="button"><span class="glyphicon glyphicon-plus"></span> Add</button>
    </section>

</div>

<div class="panel-footer">
    {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
</div>
{!! Form::close() !!}