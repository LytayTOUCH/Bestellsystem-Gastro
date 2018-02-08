<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Bestellungen\KundeBestellung;
use \App\Models\Bestellungen\BestellungProdukt;
use \App\Models\Bestellungen\Bestellung;
use \App\Models\Tisch;
use \App\Models\Bestellungen\Kunde;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class DeleteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:bestelldaten';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Löscht die Bestellungen, Kunden, Tischbelegungen etc.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        KundeBestellung::truncate();
        BestellungProdukt::truncate();
        Bestellung::truncate();
        Kunde::truncate();
        Tisch::where('Besetzt', true)->update(['Besetzt' => false]);

        $client = new Client(new Version2X(config('app.node_addr'), []));
        $client->initialize();
        $client->emit('delete all', []);
        $client->close();
    }
}
