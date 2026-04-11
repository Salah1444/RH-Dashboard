<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RhSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADDING MORE DROPDOWN / BASE DATA
        DB::table('cadre')->insert([
            ['id_cadre' => 2, 'CADRE' => 'ADM', 'Lib_cadre_AR' => 'إداري', 'Lib_Cadre_FR' => 'Administrateur'],
            ['id_cadre' => 3, 'CADRE' => 'INSP', 'Lib_cadre_AR' => 'مفتش', 'Lib_Cadre_FR' => 'Inspecteur'],
        ]);

        DB::table('fonction')->insert([
            ['id_fon' => 2, 'CODE_FONCTION' => 'F02', 'LIB_FONCTION_FR' => 'Directeur', 'LIB_FONCTION_AR' => 'مدير', 'LL_CYCLE' => 'Secondaire', 'LL_DISCIP' => 'Administration'],
            ['id_fon' => 3, 'CODE_FONCTION' => 'F03', 'LIB_FONCTION_FR' => 'Surveillant Général', 'LIB_FONCTION_AR' => 'حارس عام', 'LL_CYCLE' => 'Collège', 'LL_DISCIP' => 'Gestion'],
        ]);

        DB::table('etablissement')->insert([
            ['id_etablissement' => 2, 'CD_ETAB' => 'ET02', 'LIBELLE_FR_AFF' => 'Lycée Ibn Khaldoun', 'commune_id' => 1, 'modiriya_id' => 1, 'net_etab_id' => 1],
            ['id_etablissement' => 3, 'CD_ETAB' => 'ET03', 'LIBELLE_FR_AFF' => 'Collège Al Massira', 'commune_id' => 1, 'modiriya_id' => 1, 'net_etab_id' => 1],
        ]);

        // 2. ADDING DUMMY EMPLOYERS (Singular table name 'employer' as per your SQL dump)
        DB::table('employer')->insert([
            [
                'id_emp' => 3, 'COD_AG' => 'AG003', 'CIN' => 'BK112233', 'NOM_PRENOM_FR' => 'Youssef El Mansouri', 
                'NOM_PRENOM_AR' => 'يوسف المنصوري', 'photo' => 'youssef.jpg', 'DATE_NAISS' => '1985-04-12', 
                'SEXE' => 'M', 'VILLE' => 'Agadir', 'TEL_PORTABLE' => '0661223344', 
                'ADRESSE_ELEC' => 'youssef.mansouri@email.com', 'Sit_Familiale' => 'Marié(e)', 
                'RIB' => '007780001234567890123456', 'ville_id' => 1, 'position_id' => 1, 
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'id_emp' => 4, 'COD_AG' => 'AG004', 'CIN' => 'JM445566', 'NOM_PRENOM_FR' => 'Fatima Zahra Amrani', 
                'NOM_PRENOM_AR' => 'فاطمة الزهراء العمراني', 'photo' => 'fatima.jpg', 'DATE_NAISS' => '1992-11-20', 
                'SEXE' => 'F', 'VILLE' => 'Agadir', 'TEL_PORTABLE' => '0665556677', 
                'ADRESSE_ELEC' => 'fz.amrani@email.com', 'Sit_Familiale' => 'Célibataire', 
                'RIB' => '011120009876543210987654', 'ville_id' => 1, 'position_id' => 1, 
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'id_emp' => 5, 'COD_AG' => 'AG005', 'CIN' => 'K998877', 'NOM_PRENOM_FR' => 'Ahmed El Idrissi', 
                'NOM_PRENOM_AR' => 'أحمد الإدريسي', 'photo' => 'ahmed.jpg', 'DATE_NAISS' => '1988-07-05', 
                'SEXE' => 'M', 'VILLE' => 'Inezgane', 'TEL_PORTABLE' => '0667788990', 
                'ADRESSE_ELEC' => 'ahmed.idrissi@email.com', 'Sit_Familiale' => 'Marié(e)', 
                'RIB' => '022230005544332211009988', 'ville_id' => 1, 'position_id' => 1, 
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
        ]);

        // 3. HISTORIES & ATTACHMENTS
        DB::table('affectation')->insert([
            ['emp_id' => 3, 'etablissement_id' => 2, 'fonction_id' => 2, 'DATE_DEBUT_AFF' => '2024-09-01', 'Mode_Affectation' => 'Mutation'],
            ['emp_id' => 4, 'etablissement_id' => 3, 'fonction_id' => 1, 'DATE_DEBUT_AFF' => '2025-01-15', 'Mode_Affectation' => 'Nouvelle affectation'],
            ['emp_id' => 5, 'etablissement_id' => 1, 'fonction_id' => 3, 'DATE_DEBUT_AFF' => '2023-09-01', 'Mode_Affectation' => 'Mutation'],
        ]);

        DB::table('diplomes')->insert([
            ['emp_id' => 3, 'LL_DIPP' => 'Master', 'LL_DIPS' => 'Management de l\'éducation', 'date_obtenue' => '2010-06-15', 'etablissement_formation' => 'Faculté des Sciences Agadir'],
            ['emp_id' => 4, 'LL_DIPP' => 'Licence', 'LL_DIPS' => 'Littérature Française', 'date_obtenue' => '2014-07-10', 'etablissement_formation' => 'Université Ibn Zohr'],
        ]);

        DB::table('conjoints')->insert([
            ['emp_id' => 3, 'nom_prenom_conjoint' => 'Meryem Alami', 'cin_conj' => 'BK998822', 'nationalite_conj' => 'MA'],
        ]);

        DB::table('enfants')->insert([
            ['emp_id' => 3, 'nom_prenom_enf' => 'Amine El Mansouri', 'rang_enf' => 1, 'date_naissance_enf' => '2018-03-12', 'lien_juridique' => 'Fils'],
        ]);

        // 4. ABSENCES & LEAVES
        DB::table('congee')->insert([
            ['type_congee' => 'Maternité', 'nombre_jrs' => 98],
            ['type_congee' => 'Pèlerinage', 'nombre_jrs' => 21],
        ]);

        DB::table('absence')->insert([
            ['emp_id' => 4, 'date_debut' => '2026-04-01', 'date_fin' => '2026-04-03', 'motif' => 'Maladie', 'certificat' => 'certif_med_04.pdf'],
        ]);
    }
}