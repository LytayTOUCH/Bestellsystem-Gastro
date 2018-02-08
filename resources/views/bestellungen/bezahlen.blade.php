@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <h3>Abrechnung (Bezahlen)</h3>
                <!--{{print_r($kunden)}}-->
                @foreach($kunden as $kunde)
                	<?php
                		$preis = 0;
                		$rabatt = 0;
                	?>
                	<h4>Kunde {{$kunde->id}} / {{$kunde->tisch->Name}}</h4>
                	<div class="row">
                		<div class="col-md-8">
		                	<table class="table">
			            		@foreach($kunde->bestelltes as $bestelltes)
			            			@foreach($bestelltes->produkte as $produkt)
			            				<tr>
			            					<td><input type="checkbox" name=""></td>
			            					<td>{{\App\Models\Produkte\Produkt::find($produkt->Produkt_ID)->name}}</td>
			            					<td>{{number_format($produkt->Preis, 2, ",", ".")}} €</td>
			            					<?php $preis += $produkt->Preis; ?>
			            				</tr>
			                		@endforeach
			            		@endforeach
				            </table>
				        </div>
				        <div class="col-md-4 bg-inverse">
				        	<div class="card text-white mb-3">
							  <ul class="list-group list-group-flush">
							    <li class="list-group-item text-muted">Bestellsumme: {{number_format($preis, 2, ',', '.')}} €</li>
							    <li class="list-group-item text-muted">Abzgl. Rabatt: 0,00€</li>
							    <li class="list-group-item">Gesamtsumme: {{number_format($preis + $rabatt, 2, ',', '.')}} €</li>
							    <li class="list-group-item">
							    	<a href="#" class="btn btn-success btn-block">Rechnung wurde bezahlt</a>
							    </li>
							  </ul>
							</div>
				        </div>
			        </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection