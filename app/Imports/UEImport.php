<?php

namespace App\Imports;

use App\Models\UE;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UEImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            UE::create([
                'code' => $row['code'],
                'libelle' => $row['libelle'],
                'code_competence' => $row['code_competence'],
                'id_semestre' => $row['id_semestre']
            ]);
        }
    }

    public function sheets(): array{
        return ["INFOS-UE"=> $this];
    }
}
