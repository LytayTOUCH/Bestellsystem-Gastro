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
                <?php
                    $summe = 0;           
                ?>
                @foreach($tisch_bestellungen as $kunde)
                    <p>
                        <b>{{$kunde->tisch->Name}}</b> 
                        @if(\App\Models\Bestellungen\Kunde::offeneBestellungenCount($kunde->id) > 0)
                            <span class="badge badge-danger">Hat offene Bestellung</span>
                        @endif
                    </p>
                    <table class="table">
                        <tr>
                            <th class="w-50">Produktname</th>
                            <th class="w-25">Preis</th>
                            <th class="w-25">Aktionen</th>
                        </tr>
                        @foreach($kunde->bestelltes as $bestellung)
                            <?php $produkte = 0; ?>
                            @foreach($bestellung->produkte as $produkt)
                                <?php
                                    $produkte += 1;
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

                            @if($produkte == 0)
                                <tr>
                                    <td colspan="3">
                                        Keine Produkte oder Tisch hat offene Bestellung
                                    </td>
                                </tr>
                            @endif

                            @if($loop->last)
                            <tr>
                                <td></td>
                                <td>
                                    <b>{{number_format($summe, 2, ",", ".")}} €</b>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{route('Bestellungen.Abrechnung.Bearbeiten', ['id'=>$kunde->tisch->id])}}">Abrechnen</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                @endforeach  
            </div>
        </div>
    </div>
</div>

@endsection
