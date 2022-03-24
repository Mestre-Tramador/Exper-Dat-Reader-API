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
class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call PHPUnit to run the Tests.';

    /**
     * Run all the App's tests.
     *
     * @return int
     */
    public function handle()
    {
        return shell_exec('./vendor/bin/phpunit tests') ? self::SUCCESS : self::FAILURE;
    }
}
