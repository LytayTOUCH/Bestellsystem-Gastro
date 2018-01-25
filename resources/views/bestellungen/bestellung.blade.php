@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <h3>Neue Bestellung</h3>

                @foreach($selectedCatsAndProds as $CatWithProd)
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="heading">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$CatWithProd['name']}}" aria-expanded="false" aria-controls="collapse{{$CatWithProd['name']}}">
                                    {{$CatWithProd['name']}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$CatWithProd['name']}}" class="collapse" aria-labelledby="heading{{$CatWithProd['name']}}" data-parent="#accordion">
                            <div class="card-body">
                                <ul>
                                    @foreach($CatWithProd['produkte'] as $Product)
                                        <li>{{$Product->name}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
