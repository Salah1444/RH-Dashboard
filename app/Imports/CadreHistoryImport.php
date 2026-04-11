<?php

namespace App\Imports;

use App\Models\EmployeCadreHistory;
use App\Models\Employer;
use App\Models\Cadre;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
class CadreHistoryImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $codeAgent = $this->pickStr($r, ['code_agent', 'cod_ag']);
        $idCadre   = $this->pickStr($r, ['id_cadre']);

        if ($codeAgent === '' || $idCadre === '') return null;
        if (!Employer::where('COD_AG', $codeAgent)->exists()) return null;
        if (!Cadre::where('id_cadre', $idCadre)->exists()) return null;

        return new EmployeCadreHistory([
            'code_agent'   => $codeAgent,
            'id_cadre'     => $idCadre,
            'ANC_ADM'      => $this->pickStr($r, ['anc_adm']) ?: null,
            'DT_AFF_Cadre' => isset($r['dt_aff_cadre']) && $r['dt_aff_cadre'] !== ''
    ? Carbon::instance(ExcelDate::excelToDateTimeObject($r['dt_aff_cadre']))->format('Y-m-d')
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
