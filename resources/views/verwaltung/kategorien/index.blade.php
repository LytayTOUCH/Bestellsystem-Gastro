@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Kategorien</h1>
				<p>
					Mit Kategorien kannst du deine Produkte besser aufteilen. Kategorien können zum Beispiel "Getränke, Snacks etc." sein. Auch können deine Mitarbeiter mit Hilfe der Kategorien einfacher Bestellungen aufnehmen.
				</p>
				<hr>
				<a href="{{ route('Verwaltung.Kategorien.Erstellen') }}" class="btn btn-success">Neue Kategorie erstellen</a>
				<table class="table">
					<tr><th>Name</th><th>Aktionen</th></tr>
					@if(count($kategorien) == 0)
						<tr><td colspan="3"><i>Keine Kategorien vorhanden</i></td></tr>
					@else
						@foreach($kategorien as $kategorie)
							<tr>
								<td>{{$kategorie->name}}</td>
								<td><a href="{{ route('Verwaltung.Kategorien.Bearbeiten', ['id'=>$kategorie->id]) }}">Bearbeiten</a> | <a href="{{ route('Verwaltung.Kategorien.Entfernen', ['id'=>$kategorie->id]) }}" class="text-danger">Löschen</a></td>
							</tr>
						@endforeach
					@endif
				</table>
			</div>
		</div>
	</div>
</div>

@endsection