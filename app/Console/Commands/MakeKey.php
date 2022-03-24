<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Make the App's Key if it's unset
 * or incorrectly formatted.
 *
 * @author Mestre-Tramador
 */
class MakeKey extends Command
{
    /**
     * The `.env` key which this command handles.
     *
     * @var string
     */
    private const APP_KEY = 'APP_KEY';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make your ENV Key.';

    /**
     * Check if the App's key is set, and if
     * not try to set it on the current `.env` file.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * The App's Key.
         *
         * @var string
         */
        $app_key = env(self::APP_KEY);

        if(strlen($app_key) === 32)
        {
            return $this->OK();
        }

        /**
         * The `.env` base path.
         *
         * @var string
         */
        $env = base_path('.env');

        if(file_exists($env))
        {
            /**
             * The environment KEY.
             *
             * @var string
             */
            $key = self::APP_KEY.'=';

            /**
             * The replaced `.env` content.
             *
             * @var string
             */
            $replaced_env = str_replace($key.$app_key, $key.md5(env('APP_NAME')), file_get_contents($env));

            if(file_put_contents($env, $replaced_env))
            {
                return $this->OK('Generated Key!');
            }

            $this->error('Something gone wrong!');

            return self::FAILURE;
        }
    }

    /**
     * Mark everything as OK, finalizing
     * the command.
     *
     * @param  string  $info
     * @return int
     */
    private function OK($info = 'Everything OK!')
    {
        $this->info($info);

        return self::SUCCESS;
    }
}
