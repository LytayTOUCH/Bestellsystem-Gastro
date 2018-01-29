@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Systemdaten</h1>
				<p>
					Auf dieser Seite können die Bereinigungseinstellungen für das System festgelegt werden. Diese Funktion sollte <b>nur benutzt werden, wenn gerade kein aktiver Betrieb der Software stattfindet</b> um Kollisionen mit offenen Bestellungen zu vermeiden.
				</p>
				<hr>
				<a class="btn btn-danger" href="{{route('Verwaltung.Daten.Bereinigen')}}">Systemdaten bereinigen</a>
			</div>
		</div>
	</div>
</div>

@endsection