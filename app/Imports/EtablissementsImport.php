<?php

namespace App\Imports;

use App\Models\Etablissement;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EtablissementsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $nom = $this->pickStr($r, ['nom_etab', 'nom']);
        if ($nom === '') {
            return null;
        }

        return new Etablissement([
            'NOM_ETAB'               => $nom,
            'type_milieu'            => $this->pickStr($r, ['type_milieu', 'milieu']) ?: null,
            'Nombre_eleves'          => $this->intOrNull($this->pickRaw($r, ['nombre_eleves', 'eleves'])),
            'Disponibilite_logement' => $this->pickStr($r, ['disponibilite_logement', 'logement']) ?: null,
            'cd_commune'             => $this->pickStr($r, ['cd_commune', 'commune_id']) ?: null,
            'modiriya_id'            => $this->intOrNull($this->pickRaw($r, ['modiriya_id'])),
            'CD_NETAB'               => $this->pickStr($r, ['cd_netab', 'netab']) ?: null,
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
}
