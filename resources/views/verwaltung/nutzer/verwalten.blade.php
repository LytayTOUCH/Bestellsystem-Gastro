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
				<form class="form" method="POST" action="{{route('Verwaltung.Nutzer.ErstellenSpeichern')}}">
					{{ csrf_field() }}

					<div class="form-check">
						<input type="checkbox" name="UserActive" class="form-check-input"> 
						<label class="form-check-label" for="UserActive">Benutzerkonto freigeschaltet</label>
						<small class="form-text text-muted">Du kannst einen Benutzer temporär abschalten</small>
					</div>
					<br>
					<div class="form-group">
						<label for="FullName">Vor und Nachname</label>
						<input type="text" name="FullName" class="form-control"  autocomplete="new-fullname">
						<small class="form-text text-muted">Ein Nutzername wird zur Zuordnung von Bestellungen benötigt</small>
					</div>
					<div class="form-group">
						<label for="Mail">E-Mail Adresse</label>
						<input type="text" name="Mail" class="form-control" autocomplete="new-mail">
						<small class="form-text text-muted">Mit der E-Mail wird ein Anmelden am System ermöglicht.</small>
					</div>
					<div class="form-group">
						<label for="Passwort">Passwort</label>
						<input type="password" name="Passwort" class="form-control" autocomplete="new-password">
						<small class="form-text text-muted">Das Passwort kann später wieder geändert werden.</small>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Benutzer speichern">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection