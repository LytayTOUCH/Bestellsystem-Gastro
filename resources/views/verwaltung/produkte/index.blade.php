@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Produkte</h1>
				<p>
					Ein wichtiger Bestandteil deines Bestellsystems sind die Produkte - und genau die kannst du hier erstellen, bearbeiten und zu Kategorien zuordnen.
				</p>
				<hr>
				<a class="btn btn-success" href="{{ route('Verwaltung.Produkte.Erstellen') }}">Neues Produkt anlegen</a>
				@if (count($produkte) == 0 || count($kategorien) == 0)
					<hr>
					<i><b>Keine Produkte vorhanden</b></i>
				@else
					<hr>
					@foreach($kategorien as $kategorie)
						<h3>{{ $kategorie->name }}</h3>
							<table class="table">
							<tr>
								<th class="col-md-4">Name</th>
								<th class="col-md-4">Preis</th>
								<th class="col-md-4">Aktionen</th>
							</tr>
							@foreach( \App\Produkt::where('category', $kategorie->id)->get() as $produkt)
							<tr>
								<td>{{ $produkt->name }}</td>
								<td>{{ number_format($produkt->price, 2, ',', '.') }}€</td>
								<td>
									<a href="{{ route('Verwaltung.Produkte.Bearbeiten', ['id'=>$produkt->id]) }}">Bearbeiten</a> <a href="{{ route('Verwaltung.Produkte.Entfernen', ['id'=>$produkt->id]) }}" class="text-danger">Löschen</a>
								</td>
							</tr>
							@endforeach
						</table>
					@endforeach
				@endif
			</div>
		</div>
	</div>
</div>

@endsection