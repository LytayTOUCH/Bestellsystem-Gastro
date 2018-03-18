@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('bestellungen.shared.navigation')
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                @if(count($tische) == 0 || count($selectedCatsAndProds) == 0)
                <p>Keine Tische oder Produkte in der Verwaltung angelegt!</p>
                @else
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
                                @if(!\App\Models\SiteSettings::all()->first()->module_warenwirtschaft || $Product->infinite)
                                <input type="number" name="anzahl[{{$Product->id}}]" class="form-control" min="0" max="1000" placeholder="0">
                                @else
                                <input type="number" name="anzahl[{{$Product->id}}]" class="form-control" min="0" max="{{\App\Models\Produkte\Produkt::find($Product->id)->available}}" placeholder="0">
                                @endif
                            </td>
                            <td>
                                <label for="anzahl[{{$Product->id}}]">
                                    {{$Product->name}}
                                    @if(\App\Models\SiteSettings::all()->first()->module_warenwirtschaft && !$Product->infinite)
                                    @if(\App\Models\Produkte\Produkt::find($Product->id)->available < 5 && \App\Models\Produkte\Produkt::find($Product->id)->available > 0)
                                    <label class="text-info">(Noch {{\App\Models\Produkte\Produkt::find($Product->id)->available}} verfügbar)</label>
                                    @elseif(\App\Models\Produkte\Produkt::find($Product->id)->available == 0)
                                    <label class="text-danger">(Ausverkauft)</label>
                                    @endif
                                    @endif
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endforeach
                    <input type="submit" value="Bestellung absenden" class="form-control btn-success">
                </form>
                @endif      
            </div>
        </div>
    </div>
</div>
@endsection