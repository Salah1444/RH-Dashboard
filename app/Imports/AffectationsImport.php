<?php

namespace App\Imports;

use App\Models\Affectation;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AffectationsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $codeAgent = $this->pickStr($r, ['code_agent', 'cod_ag']);
        if ($codeAgent === '') {
            return null;
        }

        return new Affectation([
            'code_agent'          => $codeAgent,
            'code_etab'           => $this->pickStr($r, ['code_etab', 'cd_etab']) ?: null,
            'fonction_id'         => $this->intOrNull($this->pickRaw($r, ['fonction_id'])),
            'DT_AFF_POSTE'        => $this->parseDate($this->pickRaw($r, ['dt_aff_poste', 'date_poste'])),
            'DATE_DEBUT_AFF'      => $this->parseDate($this->pickRaw($r, ['date_debut_aff', 'date_debut'])),
            'Date_aff_delegation' => $this->parseDate($this->pickRaw($r, ['date_aff_delegation', 'date_delegation'])),
            'Date_aff_aref'       => $this->parseDate($this->pickRaw($r, ['date_aff_aref', 'date_aref'])),
            'Mode_Affectation'    => $this->pickStr($r, ['mode_affectation', 'mode']) ?: null,
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

    private function intOrNull(mixed $v): ?int
    {
        if ($v === null || $v === '') return null;
        return is_numeric($v) ? (int) $v : null;
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
