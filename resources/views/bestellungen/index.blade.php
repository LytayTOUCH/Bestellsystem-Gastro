@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <h3>Bestellungen</h3>
                <i>Keine offenen Bestellungen</i>
            </div>
        </div>
    </div>
</div>

@endsection
