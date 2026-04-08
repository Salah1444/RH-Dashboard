<?php

namespace App\Imports;

use App\Models\Diplome;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class DiplomesImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $libDip    = $this->pickStr($r, ['ll_dip', 'lib_diplome', 'diplome']);
        $codeAgent = $this->pickStr($r, ['code_agent', 'cod_ag']);

        if ($libDip === '' || $codeAgent === '') {
            return null;
        }

        $type = strtoupper($this->pickStr($r, ['type_dip', 'type']));
        if (!in_array($type, ['SCOLAIRE', 'PRO'])) {
            $type = 'SCOLAIRE';
        }

        return new Diplome([
            'LL_DIP'                  => $libDip,
            'DT_DIP'                  => $this->parseDate($this->pickRaw($r, ['dt_dip', 'date_diplome', 'date'])),
            'code_agent'              => $codeAgent,
            'etablissement_formation' => $this->pickStr($r, ['etablissement_formation', 'etab_formation']) ?: null,
            'montion'                 => $this->floatOrNull($this->pickRaw($r, ['montion', 'mention', 'note'])),
            'TYPE_DIP'                => $type,
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

    private function pickRaw(array $r, array $keys): mixed
    {
        foreach ($keys as $key) {
            $key = strtolower($key);
            if (!array_key_exists($key, $r)) continue;
            $v = $r[$key];
            if ($v === null || $v === '') continue;
            return $v;
        }
        return null;
    }

    private function floatOrNull(mixed $v): ?float
    {
        if ($v === null || $v === '') return null;
        return is_numeric($v) ? (float) $v : null;
    }

    private function parseDate(mixed $v): ?string
    {
        if ($v === null || $v === '') return null;
        if (is_numeric($v)) {
            try {
                return ExcelDate::excelToDateTimeObject((float) $v)->format('Y-m-d');
            } catch (\Throwable) {
                return null;
            }
        }
        if ($v instanceof \DateTimeInterface) {
            return Carbon::parse($v)->format('Y-m-d');
        }
        try {
            return Carbon::parse((string) $v)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}
