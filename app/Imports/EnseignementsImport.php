<?php

namespace App\Imports;

use App\Models\Enseignement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EnseignementsImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Enseignement::create([
                'code_prof' => $row['code_prof'],
                'id_groupe' => $row['id_groupe'],
                'code_ressource' => $row['code_ressource'],
            ]);
            
        }
    }

    public function sheets(): array{
        return ["INFOS-ENSEIGNEMENTS"=> $this];
    }
}
