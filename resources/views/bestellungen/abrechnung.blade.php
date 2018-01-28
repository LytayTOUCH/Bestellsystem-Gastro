@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <h3>Abrechnung</h3>
                {{print_r($tisch_bestellungen)}}     
            </div>
        </div>
    </div>
</div>

@endsection
