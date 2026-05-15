<?php

namespace App\Jobs;

use App\Services\NimbusPostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchNimbusShipmentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $fromDate = now()->subDays(10)->format('Y-m-d');
        $toDate   = now()->format('Y-m-d');

        NimbusPostService::fetchNimbusOrders([
            'page'      => 1,
            'per_page'  => 100, // keep lower to avoid timeout
            'from_date' => $fromDate,
            'to_date'   => $toDate,
        ]);
    }
}