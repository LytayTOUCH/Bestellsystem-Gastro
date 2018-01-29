@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Tische</h1>
				<p>
					Hier können die Tische für die Bestellungen eingerichtet werden. Derzeit ist diese Funktion auf ein Minimum beschränkt (Erstellen & Löschen).
				</p>

				<a href="{{ route('Verwaltung.Tische.Erstellen') }}" class="btn btn-sm btn-success">Neuen Tisch erstellen</a>
				<a href="{{ url('/verwaltung/tische/reset_all') }}" class="btn btn-sm btn-info">Alle Tische zurücksetzen</a>
				<hr>

				@foreach($tische as $tisch)
					<div class="card bg-light mb-6" style="width: 100%">
					  <div class="card-header">
					  	{{$tisch->Name}}
					  	@if($tisch->Besetzt == true)
					  	 <small><b>(Derzeit belegt / Abrechnung offen)</b></small>
					  	@endif
					  </div>
					  <div class="card-body">
					    <p class="card-text">
				    		<a href="{{ route('Verwaltung.Tische.Reset', ['id'=>$tisch->id]) }}" class="btn btn-sm btn-secondary btn-block">Zurücksetzen</a>
				    		<a href="{{ route('Verwaltung.Tische.Entfernen', ['id'=>$tisch->id]) }}" class="btn btn-sm btn-danger btn-block">Tisch löschen</a>
					    </p>
					  </div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection