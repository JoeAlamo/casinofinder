@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1 class="text-center">Find your nearest casino</h1>
            <div class="row margin-bottom-lg margin-top-lg">
                <div class="col-md-8 col-md-offset-2">
                    <input type="text" name="users_address" id="users_address" class="form-control hidden" placeholder="Start typing your address">
                </div>
            </div>
            <div id="casino-find-fail" class="row hidden">
                <div class="col-md-10 col-md-offset-1">
                    <div class="alert alert-danger">
                        <p><strong>Sorry!</strong> We couldn't find a casino close to your location. Try entering a different location above.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="map-responsive">
                        <div id="map">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view-casino-modal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="view-casino-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="view-casino-modal-label"></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    {!! HTML::script('https://maps.googleapis.com/maps/api/js?libraries=places') !!}
    {!! HTML::script('/assets/js/admin/casino/googleMap.js') !!}
    {!! HTML::script('/assets/js/casinofinder/casinofinder.js') !!}
@append
