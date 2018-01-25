@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Kategorien bearbeiten</h1>
				<a href="{{route('Verwaltung.Kategorien')}}">&larrhk; Zurück zu den Kategorien</a>
				<hr>

				@if ($isNewCategoryDataset)
				<form class="form" method="post" action="{{ route('Verwaltung.Kategorien.NeueSpeichern') }}">
				@else
				<form class="form" method="post" action="{{ route('Verwaltung.Kategorien.BearbeitenSpeichern', ['id' => $kategorie->id]) }}">
				@endif

					{{ csrf_field() }}
					<div class="form-group">
						<label for="categoryName">Name der Kategorie</label>
						<input type="text" id="categoryName" name="categoryName" class="form-control" value="{{ ($isNewCategoryDataset == false) ? $kategorie->name : '' }}">
						@if ($errors->has('categoryName'))
                            <span class="form-text text-danger">
                                <small>{{ $errors->first('categoryName') }}</small>
                            </span>
                        @endif
					</div>
					<div class="form-group">
						<label for="categoryDescription">Hinweis / Beschreibung <small>(Optional)</small></label>
						<input type="text" id="categoryDescription" name="categoryDescription" class="form-control" value="{{ ($isNewCategoryDataset == false) ? $kategorie->description : '' }}">
						<small class="text-muted form-text">
							Die Beschreibung erleichtert neuen Mitarbeitern das Einordnen von Produkten in eine Kategorie. 
						</small>
					</div>
					<div class="form-group">
						<input type="submit" id="categorySubmit" name="categorySubmit" class="form-control btn-primary" value="Kategorie speichern">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection