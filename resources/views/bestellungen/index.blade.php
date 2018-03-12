@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div id="orders" class="card-body">
                <!--<h3>Bestellungen</h3>-->
                    <div id="orderlist"> 
                        @if (count($bestellungen) == 0)
                            <i class="remove_on_incoming_order">Keine offenen Bestellungen</i>
                        @else
                            @foreach($bestellungen as $bestellungId => $bestellungData)
                                <div class="card card-default order" order_id="{{$bestellungId}}">
                                    <div class="card-body">
                                        <b>Bestellung von: {{\App\Models\Tisch::find($bestellungData['tisch'])->Name}}</b>
                                        <br>
                                        <table class="table">
                                            <tr>
                                                <th class="w-50">Produktname</th>
                                                <th class="w-25">Preis</th>
                                                <th class=""></th>
                                            </tr>
                                            @foreach($bestellungData['produkte'] as $produkt)
                                                <?php $produktI = \App\Models\Produkte\Produkt::find($produkt->Produkt_ID) ?>
                                                <tr>
                                                    <td>{{$produktI->name}}</td>
                                                    <td>{{number_format($produkt->Preis, 2, ',', '.')}} €</td>
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
                            @endforeach
                        @endif 
                    </div>  

                <!-- Dynamic Template -->
                <div style="display: none;">
                    <div id="order_template" class="card card-default order">
                        <div class="card-body">
                            <b>Bestellung von: <span class="order_tablename"></span></b>
                            <br>
                            <table class="table products">
                                <tr>
                                    <th class="w-50">Produktname</th>
                                    <th class="w-25">Preis</th>
                                    <th class=""></th>
                                </tr>
                            </table>
                            <a href="" class="btn btn-sm btn-info order_close_link" style="margin-top: 3px; margin-bottom: 10px;">Abschließen</a>
                            <a href="" class="btn btn-sm btn-warning order_storno_link" style="margin-top: 3px; margin-bottom: 10px;">Stornieren</a>
                        </div>
                    </div>
                </div>
                <!-- Dynamic Template Ende -->             
            </div>
        </div>
    </div>
</div>

@endsection
