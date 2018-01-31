@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Änderungen des Updates</h1>
				<p>Neue Versionsnummer: {{ config('app.version', 0) }}</p>
				<p>
					<ul>
						<li>Änderungen am Update-System (Verbesserungen nach Fehlern)</li>
						<li>Dunkles Design für bessere Ansicht im Dunklen</li>
						<li>Beginn des Abrechnung-Moduls</li>
					</ul>
				</p>
			</div>
		</div>
	</div>
</div>

@endsection