@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-xs-5 col-xs-offset-1">
            <h1>{{ $casino->name }}</h1>
        </div>
        <div class="col-xs-5">
            <a class="btn btn-primary margin-top-lg pull-right" href="{{ URL::route('admin.casino.edit', $casino->id) }}">Edit</a>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 col-md-5 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if($casino->description)
                        <p>{{ $casino->description }}</p>
                    @else
                        <p>No description added!</p>
                    @endif
                    <h2>Opening Times</h2>
                    @if($casino->casinoOpeningTimes->isEmpty())
                        <p>No opening times have been added for this casino.</p>
                    @else
                            <div class="row">
                                <div class="col-xs-4"><strong>Day</strong></div>
                                <div class="col-xs-4"><strong>Opening Time</strong></div>
                                <div class="col-xs-4"><strong>Closing Time</strong></div>
                            </div>
                    @endif
                    @foreach($casino->casinoOpeningTimes as $casinoOpeningTime)
                            <div class="row">
                                <div class="col-xs-4">
                                    {{ $casinoOpeningTime->dayString }}
                                </div>
                                <div class="col-xs-4">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $casinoOpeningTime->open_time)->format('H:i a') }}
                                </div>
                                <div class="col-xs-4">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $casinoOpeningTime->close_time)->format('H:i a') }}
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="map-responsive">
                        <div id="map" data-latitude="{{$casino->casinoLocation->latitude}}" data-longitude="{{$casino->casinoLocation->longitude}}">
                            {{-- Google Maps goes here --}}
                        </div>
                    </div>
                    <h4>{{ $casino->casinoLocation->address }}, {{ $casino->casinoLocation->city }}, {{ $casino->casinoLocation->postal_code }}</h4>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
    {!! HTML::script('https://maps.googleapis.com/maps/api/js?libraries=places') !!}
    {!! HTML::script('/assets/js/admin/casino/googleMap.js') !!}
    {!! HTML::script('/assets/js/admin/casino/showCasino.js') !!}
@append
