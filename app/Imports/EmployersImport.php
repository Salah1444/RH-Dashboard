<?php

namespace App\Imports;

use App\Models\Employer;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

/**
 * Maps columns from the UML « employer » model (and legacy headers) to the DB.
 * CV export / cv_pdf.blade.php use the same Employer fields — no change required there.
 */
class EmployersImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $r = $this->normalizeRow($row);

        $cin = $this->pickStr($r, ['cin']);
        $nomFr = $this->pickStr($r, ['nom_prenom_fr', 'nom_prenom']);

        if ($cin === '' && $nomFr === '') {
            return null;
        }

        if ($cin !== '' && Employer::query()->where('CIN', $cin)->exists()) {
            return null;
        }

        $sexe = $this->pickStr($r, ['sexe', 'genre']);
        $sexe = strtoupper(substr($sexe, 0, 1));
        if ($sexe !== 'M' && $sexe !== 'F') {
            $sexe = null;
        }

        return new Employer([
            'CIN_A' => $this->pickStr($r, ['cin_a', 'cin_alpha', 'cin_alpa']) ?: null,
            'CIN_N' => $this->pickStr($r, ['cin_n', 'cin_numeric', 'cin_num']) ?: null,
            'CIN' => $cin !== '' ? $cin : null,
            'NOM_PRENOM_FR' => $nomFr !== '' ? $nomFr : null,
            'NOM_PRENOM_AR' => $this->pickStr($r, ['nom_prenom_ar']) ?: null,
            'photo' => $this->pickStr($r, ['photo']) ?: '',
            'DATE_NAISS' => $this->parseDate($this->pickRaw($r, ['date_naiss', 'date_naissance'])),
            'LIEU_NAISS' => $this->pickStr($r, ['lieu_naiss', 'lieu_naissance']) ?: null,
            'SEXE' => $sexe,
            'CODE_NAT' => $this->pickStr($r, ['code_nat', 'code_national']) ?: null,
            'ADRESSE_FR' => $this->pickStr($r, ['adresse_fr', 'adresse']) ?: null,
            'ADRESSE_AR' => $this->pickStr($r, ['adresse_ar']) ?: null,
            'TEL_FIXE' => $this->pickStr($r, ['tel_fixe']) ?: null,
            'TEL_PORTABLE' => $this->pickStr($r, ['tel_portable']) ?: null,
            'ADRESSE_ELEC' => $this->pickStr($r, ['adresse_elec', 'adresse_email', 'email']) ?: null,
            'Sit_Familiale' => $this->pickStr($r, ['sit_familiale', 'sit_famille']) ?: null,
            'RIB' => $this->pickStr($r, ['rib']) ?: null,
            'NUM_PB' => $this->pickStr($r, ['num_pb']) ?: null,
            'ville_id' => $this->intOrNull($this->pickRaw($r, ['ville_id'])),
            'position_id' => $this->intOrNull($this->pickRaw($r, ['position_id'])),
        ]);
    }

    /**
     * @param  array<int|string, mixed>  $row
     * @return array<string, mixed>
     */
    private function normalizeRow(array $row): array
    {
        $flat = [];
        foreach ($row as $k => $v) {
            if ($k === null || $k === '') {
                continue;
            }
            $key = strtolower(trim((string) $k, " \t\n\r\0\x0B\u{FEFF}"));
            if ($key === '' || str_starts_with($key, '__')) {
                continue;
            }
            $flat[$key] = $v;
        }

        return $flat;
    }

    /**
     * @param  array<string, mixed>  $r
     */
    private function pickStr(array $r, array $keys): string
    {
        foreach ($keys as $key) {
            $key = strtolower($key);
            if (! array_key_exists($key, $r)) {
                continue;
            }
            $s = $this->str($r[$key]);
            if ($s !== '') {
                return $s;
            }
        }

        return '';
    }

    /**
     * @param  array<string, mixed>  $r
     */
    private function pickRaw(array $r, array $keys): mixed
    {
        foreach ($keys as $key) {
            $key = strtolower($key);
            if (! array_key_exists($key, $r)) {
                continue;
            }
            $v = $r[$key];
            if ($v === null || $v === '') {
                continue;
            }

            return $v;
        }

        return null;
    }

    private function str(mixed $v): string
    {
        if ($v === null) {
            return '';
        }

        return trim((string) $v);
    }

    private function intOrNull(mixed $v): ?int
    {
        if ($v === null || $v === '') {
            return null;
        }
        if (is_numeric($v)) {
            return (int) $v;
        }

        return null;
    }

    private function parseDate(mixed $v): ?string
    {
        if ($v === null || $v === '') {
            return null;
        }

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
