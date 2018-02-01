@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <form method="POST" action="{{route('Bestellungen.AufnehmenSpeichern')}}" class="form">
                    <label for="customerTable"><b>Tischauswahl</b></label>
                    <select id="customerTable" name="customerTable" class="form-control">
                        @foreach($tische as $tisch)
                            <option value="{{$tisch->id}}">{{$tisch->Name}}</option>
                        @endforeach
                    </select>
                    <hr>

                    {{csrf_field()}}
                    @foreach($selectedCatsAndProds as $CatWithProd)
                        <h4> {{$CatWithProd['name']}} </h4>
                        <table class="table table-condensed table-striped">
                            <tr style="width: 100%;">
                                <th style="width: 90px;">Anzahl</th>
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
                    @endforeach
                    <input type="submit" value="Bestellung absenden" class="form-control btn-success">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection