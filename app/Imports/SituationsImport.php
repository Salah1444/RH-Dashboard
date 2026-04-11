<?php

namespace App\Imports;

use App\Models\SituationStatutaire;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SituationsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $code = $this->pickStr($r, ['code_sit_statutaire', 'code', 'code_situation', 'code_situation_statutaire']);
        if ($code === '') {
            return null;
        }

        return new SituationStatutaire([
            'CODE_SIT_STATUTAIRE'        => $code,
            'LIB_SITUATION_STATUTAIRE_FR' => $this->pickStr($r, ['lib_situation_statutaire_fr', 'libelle_fr', 'libelle']) ?: $code,
            'LIB_SITUATION_STATUTAIRE_AR' => $this->pickStr($r, ['lib_situation_statutaire_ar', 'libelle_ar']) ?: null,
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
