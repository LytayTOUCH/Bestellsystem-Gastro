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
                @if (count($bestellungen) == 0)
                    <i>Keine offenen Bestellungen</i>
                @else
                    @foreach($bestellungen as $bestellungId => $bestellungData)
                        <b>{{\App\Tisch::find($bestellungData['tisch'])->Name}} ({{$bestellungData['zeit']}})</b>
                        <br>
                        @foreach($bestellungData['produkte'] as $produkt)
                            {{$produkt->Produkt_ID}}<br>
                        @endforeach
                    @endforeach
                @endif                
            </div>
        </div>
    </div>
</div>

@endsection
