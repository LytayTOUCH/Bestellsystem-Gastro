@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Entwickler <i class="em em-desktop_computer" style="font-size: 20px"></i></h1>
				<p>
					Diese Seite ist ausschließlich für den Entwickler sinnvoll, andernfalls kann man hier nur die nächsten Entwicklungsschritte einsehen. 
					Hier werden ebenso offene Bugs, Feature Requests und so weiter dokumentiert.
				</p>
				<h3>Anstehendes</h3>
				<p>
					Diese Liste wird direkt vom Entwicklungsserver heruntergeladen, daher dauert dieser Seitenaufruf ein wenig länger als die anderen aber man
					ist dadurch auf dem neusten Stand der Dinge. Cool, oder?
				</p>

				<b>Umzusetzendes <small>(Aktualisiert: {{date("d.m.y - H:i:s")}})</small></b>
				<ul>
					@foreach($issues as $issue)
						<li>{{$issue['title']}}</li>
					@endforeach
					
				</ul>

				@if($isDevEnv == true)
				<hr>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#developerCreateIssueModal">
					Neuen Issue erstellen
				</button>
				<a href="{{route('Verwaltung.Entwickler.Update')}}" class="btn btn-primary">
					System aktualisieren
				</a>
				<a href="{{route('Verwaltung.Entwickler.Changelog')}}" class="btn btn-info">
					Changelog
				</a>

				<!-- Modal -->
				<form method="post" action="{{ route('Verwaltung.Entwickler.CreateIssue') }}">
					<div class="modal fade" id="developerCreateIssueModal" tabindex="-1" role="dialog" aria-labelledby="developerModalIssuesLabelBy" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="developerModalIssuesLabelBy">Neuen Issue erstellen</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>

					      {{ csrf_field() }}

					      <div class="modal-body">
					        <div class="form-group">
					        	<label for="issueName">Aufgaben-/Fehlername</label>
					        	<input type="text" id="issueName" name="issueName" class="form-control" placeholder="Was sagt das Problem aus?" required value="{{old('issueName')}}">
					        </div>
					        <div class="form-group">
					        	<label for="issueDescription">Beschreibung</label>
					        	<textarea type="text" id="issueDescription" name="issueDescription" class="form-control" placeholder="Hier kannst du dein Problem beschreiben">
					        	{{old('issueDescription')}}
					        	</textarea>
					        </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
					        <input type="submit" class="btn btn-success" value="Speichern">
					      </div>
					    </div>
					  </div>
					</div>
				</form>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection