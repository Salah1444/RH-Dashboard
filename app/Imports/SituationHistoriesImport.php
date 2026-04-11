<?php

namespace App\Imports;

use App\Models\EmployeSituationStatutaireHistory;
use App\Models\Employer;
use App\Models\SituationStatutaire;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class SituationHistoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['code_agent']) && empty($row['sit_st_id'])) {
            return null;
        }

        // Helper function to find in array variations
        $pickStr = function ($arr, $keys) {
            foreach ($keys as $k) {
                if (isset($arr[$k]) && !empty($arr[$k])) {
                    return trim($arr[$k]);
                }
            }
            return null;
        };

        // Normalize row keys
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedRow[strtolower($key)] = $value;
        }

        // Extract fields with flexible column naming
        $codeAgent = $pickStr($normalizedRow, ['code_agent', 'cod_ag', 'code']);
        $sitStId = $pickStr($normalizedRow, ['sit_st_id', 'situation_id', 'sit_st']);
        $dateStr = $pickStr($normalizedRow, ['date_sit_stat', 'date_situation', 'date_statutaire']);
        $dateRetirStr = $pickStr($normalizedRow, ['date_prev_retraite', 'date_retraite', 'date_retirement']);

        if (!$codeAgent || !$sitStId) {
            return null;
        }

        // Validate employer exists
        $employer = Employer::where('COD_AG', $codeAgent)->first();
        if (!$employer) {
            return null;
        }

        // Validate situation exists
        if (is_numeric($sitStId)) {
            $situation = SituationStatutaire::where('sit_st_id', $sitStId)->first();
        } else {
            $situation = SituationStatutaire::where('CODE_SIT_STATUTAIRE', $sitStId)->first();
        }

        if (!$situation) {
            return null;
        }

        // Convert dates
        $toDate = function ($val) {
            if (!$val) return null;
            if (is_numeric($val)) {
                // Excel serial date
                $excelDate = intval($val);
                return Carbon::createFromFormat('Y-m-d', '1900-01-01')
                    ->addDays($excelDate - 2);
            }
            try {
                return Carbon::createFromFormat('Y-m-d', $val);
            } catch (\Exception $e) {
                try {
                    return Carbon::parse($val);
                } catch (\Exception $e2) {
                    return null;
                }
            }
        };

        return new EmployeSituationStatutaireHistory([
            'code_agent' => $codeAgent,
            'sit_st_id' => $situation->sit_st_id,
            'DATE_SIT_STAT' => $toDate($dateStr),
            'DATE_PREV_RETRAITE' => $toDate($dateRetirStr),
        ]);
    }
}
