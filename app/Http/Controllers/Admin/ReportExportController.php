<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Services\ReportsApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportExportController extends Controller
{
    public function __invoke(Request $request, string $format, ReportsApiService $reports): Response
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'report_type' => ['nullable', 'string', 'max:50'],
        ]);

        $query = [
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ];

        try {
            return match ($format) {
                'csv' => $this->downloadCsv($reports, $query),
                'excel' => $this->downloadExcel($reports, $query),
                'pdf' => $this->downloadPdf($reports, $query, (string) ($validated['report_type'] ?? 'operational')),
                default => abort(404),
            };
        } catch (ApiException $exception) {
            abort($exception->statusCode(), $exception->getMessage());
        }
    }

    protected function downloadCsv(ReportsApiService $reports, array $query): Response
    {
        $response = $reports->export($query, 'csv');

        return response($response->body(), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="veyli-report.csv"',
        ]);
    }

    protected function downloadExcel(ReportsApiService $reports, array $query): Response
    {
        $response = $reports->export($query, 'csv');

        return response($response->body(), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="veyli-report.xls"',
        ]);
    }

    protected function downloadPdf(ReportsApiService $reports, array $query, string $reportType): Response
    {
        $summary = data_get($reports->summary($query), 'data', []);
        $lines = [
            'VEYLI REPORT',
            'Type: '.strtoupper($reportType),
            'Range: '.$query['start_date'].' to '.$query['end_date'],
            '',
            'Total packages: '.data_get($summary, 'total_packages', 0),
            'Delivered: '.data_get($summary, 'delivered', 0),
            'In route: '.data_get($summary, 'in_route', 0),
            'Delayed: '.data_get($summary, 'delayed', 0),
            'Cancelled: '.data_get($summary, 'cancelled', 0),
            '',
            'Status summary:',
        ];

        foreach ((array) data_get($summary, 'by_status', []) as $row) {
            $lines[] = sprintf(
                '- %s: %s',
                (string) data_get($row, 'status', 'Unknown'),
                (string) data_get($row, 'total', 0)
            );
        }

        $pdf = $this->buildSimplePdf($lines);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="veyli-report.pdf"',
        ]);
    }

    protected function buildSimplePdf(array $lines): string
    {
        $streamLines = ['BT', '/F1 12 Tf', '50 780 Td'];
        $first = true;

        foreach ($lines as $line) {
            if (!$first) {
                $streamLines[] = '0 -16 Td';
            }

            $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $line);
            $text = $ascii !== false ? $ascii : $line;
            $streamLines[] = '('.$this->escapePdfText($text).') Tj';
            $first = false;
        }

        $streamLines[] = 'ET';
        $stream = implode("\n", $streamLines);

        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            "<< /Length ".strlen($stream)." >>\nstream\n{$stream}\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1)." 0 obj\n{$object}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    protected function escapePdfText(string $text): string
    {
        return str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\(', '\)'],
            $text
        );
    }
}
