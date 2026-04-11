<?php

namespace App\Imports;

use App\Models\EmployeGradesHistory;
use App\Models\Employer;
use App\Models\Grade;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
class GradeHistoryImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $codeAgent = $this->pickStr($r, ['code_agent', 'cod_ag']);
        $idGrade   = $this->pickStr($r, ['id_grade']);

        if ($codeAgent === '' || $idGrade === '') return null;
        if (!Employer::where('COD_AG', $codeAgent)->exists()) return null;
        if (!Grade::where('id_grade', $idGrade)->exists()) return null;

        return new EmployeGradesHistory([
            'code_agent'    => $codeAgent,
            'id_grade'      => $idGrade,
            'ANC_GRADE'     => $this->pickStr($r, ['anc_grade']) ?: null,
            'DAT_EFF_GR' => isset($r['dat_eff_gr']) && $r['dat_eff_gr'] !== ''
    ? Carbon::instance(ExcelDate::excelToDateTimeObject($r['dat_eff_gr']))->format('Y-m-d')
    : null,
            'MOD_AV_GRADE'  => $this->pickStr($r, ['mod_av_grade']) ?: null,
            'LIBELLE_GRADE' => $this->pickStr($r, ['libelle_grade']) ?: null,
            
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
