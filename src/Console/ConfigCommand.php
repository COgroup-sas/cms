<?php

namespace Cogroup\Cms\Console;

use Illuminate\Console\Command;

class ConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cogroupcms:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the COgroup - CMS config';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'cogroupcms-config',
            '--force' => true,
        ]);
    }
}
