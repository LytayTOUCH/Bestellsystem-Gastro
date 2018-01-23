@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                @guest
                <div class="card-body">
                    <h5 class="card-title">Einloggen</h5>
                    {{ csrf_field() }}
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email">E-Mail Adresse</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="vorname@beispiel.de">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">Passwort</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="vorname@beispiel.de">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                        Login
                                    </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="card-body">
                    <h5 class="card-title">Schnellstart</h5>
                </div>
                @endguest
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-body">
                    <h1>Herzlich Willkommen</h1>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
