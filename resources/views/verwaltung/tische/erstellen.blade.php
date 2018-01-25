@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Tisch erstellen</h1>
				<form class="form" method="post" action="{{ route('Verwaltung.Tische.ErstellenSpeichern') }}">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="tischName">Name des Tisches</label>
						<input type="text" name="Name" class="form-control" placeholder="Tisch 1" value="{{ old('Name')}}">
						@if ($errors->has('Name'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('Name') }}</small>
                            </span>
                        @endif
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Tisch speichern">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection