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
                    <b>{{$kunde->tisch->Name}}</b><br>
                    @foreach($kunde->bestelltes as $bestellung)
                    <?php
                        $summe = 0;           
                    ?>
                    <table class="table">
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
                            </tr>
                            @if ($loop->last)
                            <tr>
                                <td></td>
                                <td>
                                    <b>{{number_format($summe, 2, ",", ".")}} €</b>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                    @endforeach
                @endforeach  
            </div>
        </div>
    </div>
</div>

@endsection
