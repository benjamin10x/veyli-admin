<?php

namespace App\Livewire\Admin;

use App\Exceptions\ApiException;
use App\Services\ReportsApiService;
use Livewire\Component;

class ReportsPage extends Component
{
    public string $startDate = '';
    public string $endDate = '';
    public string $reportType = 'envios';

    public function mount(): void
    {
        $this->endDate = now()->toDateString();
        $this->startDate = now()->subDays(30)->toDateString();
    }

    public function generate(): void
    {
        $this->validate([
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date'],
            'reportType' => ['required', 'string', 'max:50'],
        ]);

        try {
            app(ReportsApiService::class)->create([
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'report_type' => $this->reportType,
            ]);

            session()->flash('success', 'Reporte generado correctamente.');
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());
        }
    }

    public function render()
    {
        $reports = [];
        $summary = [];

        try {
            $reports = data_get(app(ReportsApiService::class)->list(), 'data', []);
            $summary = data_get(app(ReportsApiService::class)->summary([
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]), 'data', []);
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return view('livewire.admin.reports-page', [
            'reports' => $reports,
            'summary' => $summary,
        ]);
    }
}
