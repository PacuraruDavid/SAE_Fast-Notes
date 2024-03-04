<?php

namespace App\Imports;

use App\Models\Utilisateur;
use App\Models\Eleve;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ElevesImport implements ToCollection, WithMultipleSheets, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            //dd($rows);
            Utilisateur::create([
                'code' => $row["code"],                
                'nom' => $row["nom"],
                'prenom' =>$row["prenom"],
                'email' => $row["email"],
                'password' => Hash::make($row["nom"].$row["prenom"].$row["groupe"]),
            ]);

            Eleve::create([
                'code'=> $row["code"],  
                'identification' => $row["identifiant"],
                'id_groupe' => $row["groupe"]
            ]);
        }
    }

    public function sheets(): array{
        return ["INFOS-ELEVES"=> $this];
    }
}
