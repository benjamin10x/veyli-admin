<?php

namespace App\Livewire\Admin;

use App\Exceptions\ApiException;
use App\Services\ReportsApiService;
use App\Support\ProvidesValidation;
use Livewire\Component;

class ReportsPage extends Component
{
    use ProvidesValidation;

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
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
            'reportType' => ['required', 'string', 'max:50'],
        ], [
            ...$this->validationMessages(),
            'endDate.after_or_equal' => 'La fecha final debe ser igual o posterior a la fecha inicial.',
        ], $this->validationAttributes([
            'startDate' => 'Fecha inicial',
            'endDate' => 'Fecha final',
            'reportType' => 'Tipo de reporte',
        ]));

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

    protected function hasValidDateRange(): bool
    {
        $start = strtotime($this->startDate);
        $end = strtotime($this->endDate);

        if ($start === false || $end === false) {
            return false;
        }

        return $end >= $start;
    }

    public function render()
    {
        $reports = [];
        $summary = [];

        try {
            $reports = data_get(app(ReportsApiService::class)->list(), 'data', []);

            if ($this->hasValidDateRange()) {
                $summary = data_get(app(ReportsApiService::class)->summary([
                    'start_date' => $this->startDate,
                    'end_date' => $this->endDate,
                ]), 'data', []);
            }
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return view('livewire.admin.reports-page', [
            'reports' => $reports,
            'summary' => $summary,
        ]);
    }
}
