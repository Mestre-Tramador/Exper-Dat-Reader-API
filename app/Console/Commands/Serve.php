<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * This command simply start the
 * application on localhost.
 *
 *
 * @author Mestre-Tramador
 */
class Serve extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start on localhost the API.';

    /**
     * Run the App locally.
     *
     * @return int
     */
    public function handle()
    {
        return shell_exec('php -S localhost:8000 -t public') ? self::SUCCESS : self::FAILURE;
    }
}
