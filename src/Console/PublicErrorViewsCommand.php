<?php

namespace Cogroup\Cms\Console;

use Illuminate\Console\Command;

class PublicErrorViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cogroupcms:errorviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Public custom error views';

    /**
     * The drip e-mail service.
     *
     * @var DripEmailer
     */
    protected $drip;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'cogroupcms-errorviews',
            '--force' => true,
        ]);
    }
}