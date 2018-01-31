@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            @guest
            <div class="card-body">
                <h5 class="card-title">Einloggen</h5>
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
                        <button type="submit" class="btn btn-success btn-block">Einloggen</button>
                    </div>

                </form>
            </div>
            @else
            <div class="card-body">
                <h5 class="card-title">Hallo {{ explode(" ", Auth::user()->name)[0] }}!</h5>
                <i>Es gab keine neuen Benachrichtigungen</i>
            </div>
            @endguest
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-body">
                @guest
                <h1>Herzlich Willkommen</h1>
                <p>
                    Willkommen im Bestellsystem für einfache Abrechnung und Bestellabwicklung. Mit diesem unschlagbaren System können Sie die Anforderungen an Ihre Bedürfnisse
                    anpassen. Und wenn es mal nicht klappen sollte, bieten wir eine ausreichende Hilfestellung an. Probieren Sie es doch einfach aus! Einen Benutzerzugang erhalten Sie
                    durch Ihren Systemadmin (oder <a href>fordern Sie Ihren Benutzerzugang</a> an)
                </p>

                @else
                    <h1>Willkommen!</h1>
                    <p>
                        Da du bestimmt direkt mit der Benutzung loslegen möchtest, kannst du mittels der Navigation zwischen verschiedenen Funktionen umschalten. Und noch viel besser: Diese Webseite ist für Mobile Endgeräte optimiert - das heißt, dass du die Software auch auf deinem Tablet, einem Smartphone oder normal über einen PC benutzen kannst. <i class="em-svg em-iphone"></i>
                    </p>
                @endguest
            </div>
        </div>
        
    </div>
</div>
@endsection
