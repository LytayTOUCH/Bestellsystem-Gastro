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
                        <div class="card card-default">
                            <div class="card-body">
                                <b>Bestellung von: {{\App\Tisch::find($bestellungData['tisch'])->Name}}</b>
                                <br>
                                <table class="table">
                                    <tr>
                                        <th>Produktname</th>
                                        <th>Preis</th>
                                        <th></th>
                                    </tr>
                                    @foreach($bestellungData['produkte'] as $produkt)
                                        <?php $produktI = \App\Produkt::find($produkt->Produkt_ID) ?>
                                        <tr>
                                            <td>{{$produktI->name}}</td>
                                            <td><small>{{number_format($produkt->Preis, 2, ',', '.')}} €</small></td>
                                            <td>
                                                <a href="{{ route('Bestellungen.Produkt.Entfernen', ['id'=>$produkt->id]) }}" class="text-muted">Entfernen</a>, 
                                                <a href="{{ route('Bestellungen.Produkt.Kostenlos', ['id'=>$produkt->id]) }}" class="text-muted">Kostenlos</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <a href="{{ route('Bestellungen.Abschliessen', ['id'=>$bestellungId]) }}" class="btn btn-sm btn-info" style="margin-top: 3px; margin-bottom: 10px;">Abschließen</a>
                                <a href="{{ route('Bestellungen.Stornieren', ['id'=>$bestellungId]) }}" class="btn btn-sm btn-warning" style="margin-top: 3px; margin-bottom: 10px;">Stornieren</a>
                            </div>
                        </div>
                        @if ($loop->remaining)
                            <br>
                        @endif
                    @endforeach
                @endif                
            </div>
        </div>
    </div>
</div>

@endsection
