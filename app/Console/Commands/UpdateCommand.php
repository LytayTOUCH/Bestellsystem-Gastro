<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dieser Befehl ermöglicht das Aktualisieren des Bestellsystems.';

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
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        ini_set('max_execution_time', 300);
        shell_exec('(cd /var/www/html && git reset --hard && git pull -f -q && composer update && php artisan migrate)');
    }
}
