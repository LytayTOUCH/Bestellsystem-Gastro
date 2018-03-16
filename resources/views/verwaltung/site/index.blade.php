@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include("verwaltung.shared.navigation")
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h1>Allgemeine Einstellungen</h1>
                <p>Auf dieser Seite können die generellen Einstellungen für die gesamte Seite vorgenommen werden.</p>
                <form class="form" method="post" action="{{route('Verwaltung.SeiteSpeichern')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="site_name" class="col-form-label">Unternehmensname</label>
                        <input id="site_name" name="site_name" type="text" class="form-control" placeholder="Name des Unternehmens" value="{{ $setting->site_name }}">
                        @if ($errors->has('site_name'))
                        <span class="form-text text-danger">
                            {{ $errors->first('site_name') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="site_template" class="col-form-label">Template der Seite</label>
                        <select name="site_template" class="form-control">
                            <optgroup label="Standard Designs">
                                <option value="black" {{ $setting->site_template == "black" ? 'selected' : '' }}>Dunkeles Design</option>
                                <option value="white" {{ $setting->site_template == "white" ? 'selected' : '' }}>Helles Design</option>
                            </optgroup>
                            
                        </select>
                        @if ($errors->has('site_template'))
                        <span class="form-text text-danger">
                            {{ $errors->first('site_template') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Speichern" class="btn btn-lg btn-success btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection