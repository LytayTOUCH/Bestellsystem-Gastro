@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Änderungen des Updates</h1>
				<p>
					<ul>
						<li>Änderungen am Update-System</li>
					</ul>
				</p>
			</div>
		</div>
	</div>
</div>

@endsection