<?php

namespace App\Imports;

use App\Models\Echelon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EchelonsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $code = $this->pickStr($r, ['cod_ech', 'code_echelon', 'echelon']);
        if ($code === '') {
            return null;
        }

        return new Echelon([
            'COD_ECH' => $code,
            'COD_ELO' => $this->pickStr($r, ['cod_elo', 'code_elo', 'elo']) ?: null,
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
