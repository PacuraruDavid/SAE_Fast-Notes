<?php

namespace App\Imports;

use App\Models\Parcours;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ParcoursImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Parcours::create([
                'id_parcour' => $row['id_parcour'],
                'id_semestre' => $row['id_semestre'],
            ]);
            
        }
    }

    public function sheets(): array{
        return ["INFOS-PARCOURS"=> $this];
    }
}
