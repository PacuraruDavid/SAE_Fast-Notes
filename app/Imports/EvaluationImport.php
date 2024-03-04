<?php

namespace App\Imports;

use App\Models\Evaluation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EvaluationImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Evaluation::create([
                'libelle' => $row['libelle'],
                'coefficient' => $row['coefficient'],
                'type' => $row['type'],
                'date_epreuve' => $row['date_epreuve'],
                'date_rattrapage' => $row['date_rattrapage'],
                'code_ressource' => $row['code_ressource'],
            ]);
            
        }
    }

    public function sheets(): array{
        return ["INFOS-EPREUVES"=> $this];
    }
}
