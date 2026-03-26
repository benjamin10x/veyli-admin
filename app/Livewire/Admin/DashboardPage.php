<?php

namespace App\Livewire\Admin;

use App\Exceptions\ApiException;
use App\Services\DashboardApiService;
use Livewire\Component;

class DashboardPage extends Component
{
    public function render()
    {
        try {
            $summary = app(DashboardApiService::class)->summary();
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());
            $summary = ['data' => [
                'scope' => 'admin',
                'totals' => [],
                'recent_packages' => [],
                'status_breakdown' => [],
                'activity_trend' => [],
                'top_clients' => [],
                'latest_events' => [],
            ]];
        }

        return view('livewire.admin.dashboard-page', [
            'scope' => data_get($summary, 'data.scope', 'admin'),
            'totals' => data_get($summary, 'data.totals', []),
            'recentPackages' => data_get($summary, 'data.recent_packages', []),
            'statusBreakdown' => data_get($summary, 'data.status_breakdown', []),
            'activityTrend' => data_get($summary, 'data.activity_trend', []),
            'topClients' => data_get($summary, 'data.top_clients', []),
            'latestEvents' => data_get($summary, 'data.latest_events', []),
        ]);
    }
}
