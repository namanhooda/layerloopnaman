<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('cron_test')->insert([
            'message' => 'Cron executed successfully',
            'executed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->info('Cron executed successfully.');

        return self::SUCCESS;
    }
}
