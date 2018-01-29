@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Verwaltung</h1>
				<p>
					Am besten suchst du dir erstmal einen der passenden Menüpunkte auf der linken Navigation aus und dann erklären wir dir auf der jeweiligen Seite wie es weiter geht. Und glaube mir: So schwer ist das nicht. <i class="em em-bear"></i> (Glaube mir, dieser Bär kann nicht lügen!)
				</p>

				<div class="row">
					<div class="col-md-6">
						<button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#showSystemInformation" aria-expanded="false" aria-controls="showSystemInformation">
				    		Systeminformationen anzeigen
			  			</button>
						<div class="collapse" id="showSystemInformation">
							<div class="card card-body">
								<table class="table">
									<tr>
										<th>Software-Version (Rev.)</th>
										<td>{{ config('app.version', 0) }}</td>
									</tr>
									<tr>
										<th>Webseiten-Cache aktualisiert</th>
										<td>{{ date("d.m.y \/ H:i:s") }}</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<button class="btn btn-secondary btn-block" type="button" data-toggle="collapse" data-target="#showContactToDeveloper" aria-expanded="false" aria-controls="showContactToDeveloper">
				    		Entwickler kontaktieren
			  			</button>
						<div class="collapse" id="showContactToDeveloper">
							<div class="card card-body">
								<p>
									Bevor du diesen Schritt in Erwägung ziehst, stelle sicher, dass du folgende Schritte vorher erledigt hast:
									<ol>
										<li>Seiten und Browsercache gelöscht</li>
										<li>Fehler auf anderem Gerät geprüft</li>
										<li>Ggf. die Einstellungen geprüft</li>
									</ol>
								</p>
								<a href="mailto:dennis@cloudmaker97.de?subject=[Bestellsystem] Problem mit Revision 0000&body=Ich habe ein Problem mit:%20" class="btn btn-secondary btn-block">E-Mail</a>
								<a href="tel:+491707351345" class="btn btn-secondary btn-block">Telefonisch</a>
							</div>
						</div>
					</div>
				</div>

				

			  	

			</div>
		</div>
	</div>
</div>

@endsection