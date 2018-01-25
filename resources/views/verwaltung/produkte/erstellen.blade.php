@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		@include("verwaltung.shared.navigation")
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<h1>Produkte bearbeiten</h1>
				<a href="{{route('Verwaltung.Produkte')}}">&larrhk; Zurück zu den Produkten</a>
				<hr>

				@if (count($kategorien) == 0)

					<b>Zuerst eine <a href="{{ route('Verwaltung.Kategorien.Erstellen') }}">Kategorie erstellen</a> zum Anlegen eines Produktes</b>

				@else

					@if ($isNewCategoryDataset)
					<form class="form" method="post" action="{{ route('Verwaltung.Produkte.ErstellenSpeichern') }}">
					@else
					<form class="form" method="post" action="{{ route('Verwaltung.Produkte.BearbeitenSpeichern', ['id' => $product->id]) }}">
					@endif

						{{ csrf_field() }}
						<div class="form-group">
							<label for="productName">Name des Produktes</label>
							<input type="text" id="productName" name="productName" class="form-control" value="{{ ($isNewCategoryDataset == false) ? $product->name : old('productName') }}" placeholder="Kartoffelchips">
							@if ($errors->has('productName'))
	                            <span class="form-text text-danger">
	                                <small>{{ $errors->first('productName') }}</small>
	                            </span>
	                        @endif
						</div>
						<div class="form-group">
							<label for="productDescription">Beschreibung <small>(Optional)</small></label>
							<textarea type="text" id="productDescription" name="productDescription" class="form-control" placeholder="Eine passende Beschreibung...">{{ ($isNewCategoryDataset == false) ? $product->description : old('productDescription') }}</textarea> 
							@if ($errors->has('productDescription'))
	                            <span class="form-text text-danger">
	                                <small>{{ $errors->first('productDescription') }}</small>
	                            </span>
	                        @endif
						</div>
						<div class="form-group">
							<label for="productPrice">Preis</label>
							<input type="number" step="any" id="productPrice" name="productPrice" class="form-control" value="{{ ($isNewCategoryDataset == false) ? $product->price : old('productPrice') }}" placeholder="12,30">
							@if ($errors->has('productPrice'))
	                            <span class="form-text text-danger">
	                                <small>{{ $errors->first('productPrice') }}</small>
	                            </span>
	                        @endif
						</div>
						<div class="form-group">
							<label for="productCategory">Produktkategorie</label>
						    <select class="form-control" id="productCategory" name="productCategory">
						    	@foreach($kategorien as $kategorie)
						    		<option value="{{ $kategorie->id }}" {{ ($isNewCategoryDataset == false && $product->category == $kategorie->id ) ? 'selected' : 0 }}>{{ $kategorie->name }}</option>
						    	@endforeach
						    </select>
							@if ($errors->has('productCategory'))
	                            <span class="form-text text-danger">
	                                <small>{{ $errors->first('productCategory') }}</small>
	                            </span>
	                        @endif
						</div>
						<div class="form-group">
							<input type="submit" id="productSubmit" name="categorySubmit" class="form-control btn-primary" value="Produkt speichern">
						</div>
					</form>

				@endif
			</div>
		</div>
	</div>
</div>

@endsection