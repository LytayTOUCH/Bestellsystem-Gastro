<?php

namespace App\Http\Controllers\Verwaltung;
use App\Http\Controllers\AuthController;
use App\Models\Helper\UserLogs;
use Carbon\Carbon;
use Github\Client;
use Artisan;
use Illuminate\Http\Request;

class EntwicklerController extends AuthController
{
	private $githubClient;
	private $splitRepoEnv;
	private $isDevEnv = false;

	public function __construct() {
		parent::__construct();

		// Github Client creation
		$this->splitRepoEnv = explode("/", env('GITHUB_REPO'));
    	$this->githubClient = new Client();
    	$this->githubClient->authenticate(env('GITHUB_KEY'), null, Client::AUTH_HTTP_TOKEN);

    	// Check if env. is development-area
    	$this->isDevEnv = (env('APP_ENV') == "development") ? true : false;
	}

    public function index() {
    	$issues = $this->githubClient->api('issue')->all($this->splitRepoEnv[0], $this->splitRepoEnv[1], array('state' => 'open'));
    	return view("verwaltung.entwickler.index", ['issues' => $issues, 'isDevEnv' => $this->isDevEnv]);
    }

    public function CreateIssue(Request $request) {
    	$this->githubClient->api('issue')->create($this->splitRepoEnv[0], $this->splitRepoEnv[1], [
    		"title" => $request->input('issueName'),
    		"body" => $request->input('issueDescription')
    	]);

    	return redirect(route('Verwaltung.Entwickler'))->with('message', 'Die Aufgabe wurde an das Entwicklungssystem weitergegeben');;
    }

    public function changelog() {
        $changelog = $this->githubClient->api('repo')->commits()->all($this->splitRepoEnv[0], $this->splitRepoEnv[1], array('sha' => 'master'));
        if(!empty($changelog)) {
            $commits = [];
            foreach($changelog as $change) {
                if(strpos($change['commit']['message'], 'Neue Version erstellt') !== false ) {
                    break;
                }

                $commits[] = $change['commit']['message'];
            }
        }
        return view('verwaltung.entwickler.changelog', ['commits' => $commits]);
    }

    public function logs() {
        Carbon::setLocale('de');
	    $logs = UserLogs::with('user')->where('created_at', '>=', Carbon::now()->subDay())->orderBy('id', 'DESC')->get();
	    return view('verwaltung.entwickler.logs', ['logs'=>$logs]);
    }

    public function update()
    {
        Artisan::call('update:start');
        return redirect(route('Verwaltung.Entwickler.Changelog'))->with('message', 'Das System wurde aktualisiert');
    }
}
