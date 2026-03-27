<?php

namespace Theme\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Theme\Actions\ExportVacanciesAction;

class VacancyExportController extends Controller
{

    /**
     * Export vacancies to CSV.
     *
     * @param ExportVacanciesAction $action
     * @return ResponseFactory|\Symfony\Component\HttpFoundation\Response|\Themosis\Core\Application
     * @throws BindingResolutionException
     */
    public function export(ExportVacanciesAction $action)
    {
        $result = $action->execute();

        if (isset($result['error'])) {
            return response($result['error'], $result['status'] ?? 404);
        }

        $header = $result['header'];
        $data = $result['data'];

        if (request()->has('debug')) {
            return $this->renderDebugTable($header, $data);
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="vacatures.csv"',
        ];

        $callback = function () use ($header, $data) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, $header);

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Render debug table.
     *
     * @param array $header
     * @param array $data
     * @return Response
     * @throws BindingResolutionException
     */
    protected function renderDebugTable(array $header, array $data): Response
    {
        $html = '<table border="1" style="border-collapse: collapse; width: 100%;">';
        $html .= '<thead><tr>';
        foreach ($header as $column) {
            $html .= '<th style="padding: 8px; text-align: left; background-color: #f2f2f2;">' . htmlspecialchars($column) . '</th>';
        }
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td style="padding: 8px; vertical-align: top;">' . nl2br(htmlspecialchars($cell)) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        return response($html);
    }
}
