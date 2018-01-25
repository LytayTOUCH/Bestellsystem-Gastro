@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Tische</h1>
				<p>
					Hier können die Tische für die Bestellungen eingerichtet werden. Derzeit ist diese Funktion auf ein Minimum beschränkt (Erstellen & Löschen).
				</p>

				<a href="{{ url('/verwaltung/tische/reset_all') }}" class="btn btn-sm btn-info-">Alle Tische zurücksetzen</a>
				<hr>

				<div class="card bg-light mb-6" style="width: 100%">
				  <div class="card-header">Tisch 1</div>
				  <div class="card-body">
				    <p class="card-text">
				    	<div class="row">
				    		<div class="col-md-6">
					    		<a href="{{ url('/verwaltung/tische/reset', ['tisch'=>1]) }}" class="btn btn-sm btn-secondary btn-block">Zurücksetzen</a><br>
				    		</div>
				    		<div class="col-md-6">
					    		<a href="{{ url('/verwaltung/tische/delete', ['tisch'=>1]) }}" class="btn btn-sm btn-danger btn-block">Tisch löschen</a>
				    		</div>
					    </div>
				    </p>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection