<?php

namespace App\Services;

use Google\Client;
use Google\Service\AnalyticsData;

class GoogleAnalyticsService
{
    protected $analytics;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json')); // your JSON key file
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');

        $this->analytics = new AnalyticsData($client);
    }

    public function getReport()
    {
        $propertyId = '502257525'; // e.g., 123456789

        $request = new \Google\Service\AnalyticsData\RunReportRequest([
            'dimensions' => [
                ['name' => 'date']
            ],
            'metrics' => [
                ['name' => 'activeUsers'],
                ['name' => 'screenPageViews']
            ],
            'dateRanges' => [
                ['startDate' => '7daysAgo', 'endDate' => 'today']
            ]
        ]);

        $response = $this->analytics->properties->runReport(
            "properties/{$propertyId}",
            $request
        );

        return $response->getRows();
    }
}
