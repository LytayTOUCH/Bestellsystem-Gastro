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
						<li>Hinweise auf offene Bestellungen bei der Abrechnung</li>
						<li>Dunkles Design angepasst</li>
					</ul>
				</p>
			</div>
		</div>
	</div>
</div>

@endsection