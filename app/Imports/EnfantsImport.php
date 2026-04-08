<?php

namespace App\Imports;

use App\Models\Enfant;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class EnfantsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $codeAgent = $this->pickStr($r, ['code_agent', 'cod_ag']);
        $nomEnf    = $this->pickStr($r, ['nom_enf', 'nom_enfant', 'nom']);

        if ($codeAgent === '' || $nomEnf === '') {
            return null;
        }

        return new Enfant([
            'code_agent'         => $codeAgent,
            'nom_enf'            => $nomEnf,
            'prenom'             => $this->pickStr($r, ['prenom']) ?: null,
            'rang_enf'           => $this->intOrNull($this->pickRaw($r, ['rang_enf', 'rang'])),
            'date_naissance_enf' => $this->parseDate($this->pickRaw($r, ['date_naissance_enf', 'date_naissance', 'date_naiss'])),
            'lien_juridique'     => $this->pickStr($r, ['lien_juridique', 'lien']) ?: null,
            'situation_enf'      => $this->pickStr($r, ['situation_enf', 'situation']) ?: null,
            'gard_id'            => $this->intOrNull($this->pickRaw($r, ['gard_id', 'garde_id'])),
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
