@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Benutzer {{($newDataSet == true) ? "verwalten" : "bearbeiten" }}</h1>
				@if($newDataSet == true)
				<form class="form" method="POST" action="{{route('Verwaltung.Nutzer.ErstellenSpeichern')}}">
				@else
				<form class="form" method="POST" action="{{route('Verwaltung.Nutzer.BearbeitenSpeichern', ['id'=>$user->id])}}">
				@endif

					{{ csrf_field() }}
					<!--
					<div class="form-check">
						<input type="checkbox" name="active" class="form-check-input"> 
						<label class="form-check-label" for="active">Benutzerkonto freigeschaltet</label>
						<small class="form-text text-muted">Du kannst einen Benutzer temporär abschalten</small>
					</div>
					<br>-->
					<div class="form-group">
						<label for="name">Vor und Nachname</label>
						<input type="text" name="name" class="form-control"  autocomplete="new-fullname" required="true" min="3" value="{{ ($newDataSet == false) ? $user->name : old('name') }}">
						<small class="form-text text-muted">Ein Nutzername wird zur Zuordnung von Bestellungen benötigt</small>
						@if ($errors->has('name'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('name') }}</small>
                            </span>
                        @endif
					</div>
					<div class="form-group">
						<label for="email">E-Mail Adresse</label>
						<input type="text" name="email" class="form-control" autocomplete="new-mail" required="true" value="{{ ($newDataSet == false) ? $user->email : old('email') }}">
						<small class="form-text text-muted">Mit der E-Mail wird ein Anmelden am System ermöglicht.</small>
						@if ($errors->has('email'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('email') }}</small>
                            </span>
                        @endif
					</div>
					<div class="form-group">
						<label for="password">Passwort</label>
						<input type="password" name="password" class="form-control" autocomplete="new-password" 
						value="{{ ($newDataSet == false) ? '' : old('password') }}" {{($newDataSet == true ? "required" : "")}}>
						<small class="form-text text-muted">
							@if($newDataSet == true)
								Das Passwort kann später wieder geändert werden.
							@else
								Wenn das Passwort gleich bleiben soll, einfach leer lassen.
							@endif
						</small>
						@if ($errors->has('password'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('password') }}</small>
                            </span>
                        @endif
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