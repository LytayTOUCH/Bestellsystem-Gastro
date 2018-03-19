@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include("verwaltung.shared.navigation")
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h1>Logeinträge</h1>
                    <p>
                        Diese Einträge dienen dem Zweck der Überwachung und Optimierung des Systems.
                        Bei Auffälligkeiten in den Datensätzen wenden Sie sich umgehend an Ihren Administrator.
                        Angezeigt werden jeweils die Einträge der letzten 24 Stunden. <b>Derzeit werden nur Log-Einträge für die Verwaltung geschrieben</b>
                    </p>
                    @if(count($logs) == 0)
                        <b>Keine Logeinträge vorhanden</b>
                    @else
                        @foreach($logs as $log)

                            <div class="row">
                                <div class="col-12 card card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <b>Benutzer:</b><br>{{$log->user->name}}
                                        </div>
                                        <div class="col-md-8">
                                            <b>Eintrag:</b><br>
                                            <code>{{$log->log_message}}</code><br>
                                            <code><b>{{$log->action}}</b></code>
                                        </div>
                                    </div>
                                    <b>Zeit:</b>
                                    <abbr title="IP-Adresse: {{$log->computer_adress}}">{{$log->created_at}} ({{$log->created_at->diffForHumans()}})</abbr>
                                </div>
                            </div>

                            <br>

                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection