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
                @foreach($tisch_bestellungen as $kunde)
                    <p>
                        <b>{{$kunde->tisch->Name}}</b> 
                        @if(\App\Kunde::offeneBestellungenCount($kunde->id) > 0)
                            <span class="badge badge-danger">Hat offene Bestellung</span>
                        @endif
                    </p>
                    <table class="table">
                        <tr>
                            <th>Produktname</th>
                            <th>Preis</th>
                            <th>Aktionen</th>
                        </tr>
                        <?php
                            $summe = 0;           
                        ?>
                    @foreach($kunde->bestelltes as $bestellung)
                        @foreach($bestellung->produkte as $produkt)
                            <?php 
                                $summe += $produkt->Preis;
                            ?>
                            <tr>
                                <td>
                                    {{$produkt->produkt->name}}
                                </td>
                                <td>
                                    {{number_format($produkt->Preis, 2, ",", ".")}} €
                                </td>
                                <td>
                                    <a href="{{route('Bestellungen.Produkt.Kostenlos', ['id'=>$produkt->id])}}" class="text-muted">Kostenlos</a> | <a href="{{route('Bestellungen.Produkt.Entfernen', ['id'=>$produkt->id])}}" class="text-danger">Entfernen</a>
                                </td>
                            </tr>
                        @endforeach
                        
                            <tr>
                                <td></td>
                                <td>
                                    <b>{{number_format($summe, 2, ",", ".")}} €</b>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info">Abrechnen</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endforeach  
            </div>
        </div>
    </div>
</div>

@endsection
