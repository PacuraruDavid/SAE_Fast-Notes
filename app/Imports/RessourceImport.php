<?php

namespace App\Imports;

use App\Models\Ressource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RessourceImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Ressource::create([
                'code' => $row['code'],
                'libelle' => $row['libelle']
            ]);
        }
    }

    public function sheets(): array{
        return ["INFOS-RESSOURCES"=> $this];
    }
}
