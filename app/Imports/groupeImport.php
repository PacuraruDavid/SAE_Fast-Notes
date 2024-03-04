<?php

namespace App\Imports;

use App\Models\Groupe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GroupeImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Groupe::create([
                'id' => $row['id'],
                'libelle' => $row['libelle'],
                'parcours' => $row['parcours']
            ]);
        }
    }

    public function sheets(): array{
        return ["INFOS-GROUPES"=> $this];
    }
}
