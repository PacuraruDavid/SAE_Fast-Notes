<?php

namespace App\Imports;

use App\Models\Annee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnneesImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Annee::create([
                'id_annee' => $row['annee_debut'].'-'.$row['annee_fin'],
                'annee_debut' => $row['annee_debut'],
                'annee_fin' => $row['annee_fin'],
            ]);
            
        }
    }

    public function sheets(): array{
        return ["INFOS-ANNEES"=> $this];
    }
}
