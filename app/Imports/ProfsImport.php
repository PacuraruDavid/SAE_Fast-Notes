<?php

namespace App\Imports;

use App\Models\Utilisateur;
use App\Models\Professeur;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProfsImport implements ToCollection, WithMultipleSheets, WithHeadingRow
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
                'password' => Hash::make($row["nom"].$row["prenom"].$row["code"]),
            ]);

            Professeur::create([
                'code'=> $row["code"],  
                'isProf' => 1,
            ]);
        }
    }

    public function sheets(): array{
        return ["INFOS-PROFS"=> $this];
    }
}
