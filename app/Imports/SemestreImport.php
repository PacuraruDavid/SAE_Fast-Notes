<?php

namespace App\Imports;

use App\Models\Semestre;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SemestreImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Semestre::create([
                'id_semestre' => substr($row['libelle'], -1) . '_' . $row['annee'],
                'libelle' => $row['libelle'],
                'id_annee' => $row['annee'],
            ]);
        }
    }

    public function sheets(): array{
        return ["INFOS-SEMESTRES"=> $this];
    }
}
