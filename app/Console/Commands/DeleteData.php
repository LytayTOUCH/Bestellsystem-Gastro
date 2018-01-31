<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\KundeBestellung;
use \App\BestellungProdukt;
use \App\Bestellung;
use \App\Tisch;
use \App\Kunde;

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
    }
}