@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Entwickler <i class="em em-desktop_computer" style="font-size: 20px"></i></h1>
				<p>
					Diese Seite ist ausschließlich für den Entwickler sinnvoll, andernfalls kann man hier nur die nächsten Entwicklungsschritte einsehen. 
					Hier werden ebenso offene Bugs, Feature Requests und so weiter dokumentiert.
				</p>
				<h2>What's next?</h2>
				<ul>
					<li>Benutzerverwaltung</li>
					<li>Rabatte (Zeitbedingt und Kategorienbasiert)</li>
					<li>Einrichten von Bedienplätzen für die Gastverwaltung</li>
					<li>Bestellungen aufnehmbar machen und visualisieren</li>
					<li>Verrechnen von Bestellungen eines Gastes zum Ende</li>
				</ul>
			</div>
		</div>
	</div>
</div>

@endsection