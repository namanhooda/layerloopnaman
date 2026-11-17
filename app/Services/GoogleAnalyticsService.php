<?php

namespace App\Services;

use Google\Client;
use Google\Service\AnalyticsData;
use Carbon\Carbon;

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

    public function getReporttotsl($month = null)
{
    $propertyId = '502257525';

    // Default: Current month
    $selectedMonth = $month
        ? Carbon::createFromFormat('Y-m', $month)
        : Carbon::now();

    $startDate = $selectedMonth->copy()->startOfMonth()->format('Y-m-d');
    $endDate = $selectedMonth->copy()->endOfMonth()->format('Y-m-d');

    // Google Analytics request
    $request = new \Google\Service\AnalyticsData\RunReportRequest([
        'metrics' => [
            ['name' => 'activeUsers'],
            ['name' => 'screenPageViews'],
            ['name' => 'sessions'],
        ],
        'dateRanges' => [
            [
                'startDate' => $startDate,
                'endDate'   => $endDate,
            ]
        ]
    ]);

    $response = $this->analytics->properties->runReport(
        "properties/{$propertyId}",
        $request
    );

    $row = $response->getRows()[0] ?? null;

    return [
        'month' => $selectedMonth->format('F Y'),
        'activeUsers' => (int) ($row?->getMetricValues()[0]->getValue() ?? 0),
        'pageViews' => (int) ($row?->getMetricValues()[1]->getValue() ?? 0),
        'visits' => (int) ($row?->getMetricValues()[2]->getValue() ?? 0),
    ];
}
}
