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
                'today_metrics' => [],
                'activity_insights' => [],
                'event_type_breakdown' => [],
                'capacity_breakdown' => [],
                'operational_health' => [],
                'attention_metrics' => [],
                'portfolio_health' => [],
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
            'todayMetrics' => data_get($summary, 'data.today_metrics', []),
            'activityInsights' => data_get($summary, 'data.activity_insights', []),
            'eventTypeBreakdown' => data_get($summary, 'data.event_type_breakdown', []),
            'capacityBreakdown' => data_get($summary, 'data.capacity_breakdown', []),
            'operationalHealth' => data_get($summary, 'data.operational_health', []),
            'attentionMetrics' => data_get($summary, 'data.attention_metrics', []),
            'portfolioHealth' => data_get($summary, 'data.portfolio_health', []),
        ]);
    }
}
