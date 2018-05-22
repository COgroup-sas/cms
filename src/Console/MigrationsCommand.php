<?php

namespace Cogroup\Cms\Console;

use Illuminate\Console\Command;

class MigrationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cogroupcms:migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the COgroup - CMS migrations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'cogroupcms-migrations',
            '--force' => true,
        ]);
    }
}
