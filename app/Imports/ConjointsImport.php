<?php

namespace App\Imports;

use App\Models\Conjoint;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ConjointsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $codeAgent = $this->pickStr($r, ['code_agent', 'cod_ag']);
        $nomConj   = $this->pickStr($r, ['nom_prenom_conjoint', 'nom_conjoint', 'conjoint']);

        if ($codeAgent === '' || $nomConj === '') {
            return null;
        }

        return new Conjoint([
            'code_agent'          => $codeAgent,
            'DATE_SIT_FAM'        => $this->parseDate($this->pickRaw($r, ['date_sit_fam', 'date_situation', 'date'])),
            'nom_prenom_conjoint' => $nomConj,
            'rang_conj'           => $this->intOrNull($this->pickRaw($r, ['rang_conj', 'rang'])),
            'cin_conj'            => $this->pickStr($r, ['cin_conj', 'cin']) ?: null,
            'nationalite_conj'    => $this->pickStr($r, ['nationalite_conj', 'nationalite']) ?: null,
            'fonction_conj'       => $this->pickStr($r, ['fonction_conj', 'fonction']) ?: null,
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
