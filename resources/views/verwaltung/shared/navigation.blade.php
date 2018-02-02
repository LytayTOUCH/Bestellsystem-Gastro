<div class="card">
	<div class="card-body">
		<ul class="nav flex-column">
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false ? '' : 'text-success' }}" href="{{ route('Verwaltung') }}">Zur Übersicht</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'kategorien' ? 'text-info' : '' }}" href="{{ route('Verwaltung.Kategorien') }}">Kategorien</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'produkte' ? 'text-info' : '' }}" href="{{ route('Verwaltung.Produkte') }}">Produkte</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'tische' ? 'text-info' : '' }}" href="{{ route('Verwaltung.Tische') }}">Tische</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'nutzer' ? 'text-info' : '' }}" href="{{ route('Verwaltung.Nutzer') }}">Benutzer</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'daten' ? 'text-info' : '' }}" href="{{ route('Verwaltung.Daten') }}">Systemdaten</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'entwickler' ? 'text-info' : '' }}" href="{{ route('Verwaltung.Entwickler') }}">Entwickler</a></li>
		</ul>
	</div>
</div>