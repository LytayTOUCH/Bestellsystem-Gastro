@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                @foreach($selectedCatsAndProds as $CatWithProd)
                
                    
                   <h3> {{$CatWithProd['name']}} </h3>
                    <form method="POST" action="" class="form">

                    <table class="table table-condensed table-striped">
                        <tr style="width: 100%;">
                            <th style="width: 60px;">Anzahl</th>
                            <th>Produktname</th>
                        </tr>
                        @foreach($CatWithProd['produkte'] as $Product)
                        <tr>
                            <td>
                                <input type="number" name="anzahl[{{$Product->id}}]" class="form-control" value="0" min="0" max="1000">
                            </td>
                            <td>
                                <label for="anzahl[{{$Product->id}}]">{{$Product->name}}</label>
                            </td>
                        </tr>

                        @endforeach
                    </table>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
