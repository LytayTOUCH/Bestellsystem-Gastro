@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Benutzer verwalten</h1>
				<p>Unter Benutzern versteht man hier deine Mitarbeiter, welche das Tagesgeschäft als auch die Bestellungen bearbeiten und Abrechnungen durchführen. Was genau die Mitarbeiter dürfen, kannst du auch in den Einstellungen festlegen.</p>
				<a class="btn btn-success" href="{{route('Verwaltung.Nutzer.Erstellen')}}">Benutzer erstellen</a> <hr>
				<table class="table">
					<tr>
						<th>Nutzername</th>
						<th>E-Mail</th>
						<th>Aktionen</th>
					</tr>
					@if(count($nutzer) == 0)
						<tr><td colspan="3">Keine anderen Benutzer vorhanden :-(</td></tr>
					@else
						@foreach($nutzer as $user)
							<tr>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>
									<a href="{{ route('Verwaltung.Nutzer.Bearbeiten', ['id'=>$user->id]) }}">Bearbeiten</a> | 
									<a href="{{ route('Verwaltung.Nutzer.Entfernen', ['id'=>$user->id]) }}" class="text-danger">Löschen</a>
								</td>
							</tr>
						@endforeach
					@endif
				</table>
			</div>
		</div>
	</div>
</div>

@endsection