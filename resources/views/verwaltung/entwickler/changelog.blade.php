@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-body">
				<h1>Neues in der aktuellesten Version</h1>
				<p>
					Diese Neuerungen schließen den neusten Stand ein und repräsentieren nicht die Updates für alleinig dieses System.
				</p>
				<p>
					@if(count($commits) == 0)
					In der aktuellen Version sind noch keine Versionshinweise vorhanden.
					@else
					<ul>
						@foreach($commits as $commit)
							<li>{{$commit}}</li>
						@endforeach
					</ul>
					@endif
				</p>
			</div>
		</div>
	</div>
</div>

@endsection