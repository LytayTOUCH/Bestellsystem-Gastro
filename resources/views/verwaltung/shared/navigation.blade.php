<div class="card">
	<div class="card-body">
		<ul class="nav flex-column">
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false ? '' : 'text-success' }}" href="{{ route('Verwaltung') }}">Zur Übersicht</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'kategorien' ? 'text-success' : '' }}" href="{{ route('Verwaltung.Kategorien') }}">Kategorien</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'produkte' ? 'text-success' : '' }}" href="{{ route('Verwaltung.Produkte') }}">Produkte</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'tische' ? 'text-success' : '' }}" href="{{ route('Verwaltung.Tische') }}">Tische</a></li>
			<li class="nav-item"><a class="nav-link {{ strpos(Request::path(), '/') !== false && explode('/', Request::path())[1] == 'entwickler' ? 'text-success' : '' }}" href="{{ route('Verwaltung.Entwickler') }}">Entwickler</a></li>
		</ul>
	</div>
</div>