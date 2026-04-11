<?php

namespace App\Imports;

use App\Models\EmployeEchelonHistory;
use App\Models\Employer;
use App\Models\Echelon;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
class EchelonHistoryImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $codeAgent = $this->pickStr($r, ['code_agent', 'cod_ag']);
        $idEch     = $this->pickStr($r, ['id_ech']);

        if ($codeAgent === '' || $idEch === '') return null;
        if (!Employer::where('COD_AG', $codeAgent)->exists()) return null;
        if (!Echelon::where('id_ech', $idEch)->exists()) return null;

        return new EmployeEchelonHistory([
            'code_agent'  => $codeAgent,
            'id_ech'      => $idEch,
            'INDICE'      => $this->pickStr($r, ['indice']) ?: null,
            'DAT_EFF_ELO' => isset($r['dat_eff_elo']) && $r['dat_eff_elo'] !== ''
    ? Carbon::instance(ExcelDate::excelToDateTimeObject($r['dat_eff_elo']))->format('Y-m-d')
    : null,
    ]);
    }

    private function normalizeRow(array $row): array
    {
        $flat = [];
        foreach ($row as $k => $v) {
            if ($k === null || $k === '') continue;
            $key = strtolower(trim((string) $k, " \t\n\r\0\x0B\u{FEFF}"));
            if ($key === '' || str_starts_with($key, '__')) continue;
            $flat[$key] = $v;
        }
        return $flat;
    }

    private function pickStr(array $r, array $keys): string
    {
        foreach ($keys as $key) {
            $key = strtolower($key);
            if (!array_key_exists($key, $r)) continue;
            $s = trim((string) ($r[$key] ?? ''));
            if ($s !== '') return $s;
        }
        return '';
    }
}
