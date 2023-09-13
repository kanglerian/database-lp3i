<?php

namespace App\Imports;

use App\Models\School;
use Maatwebsite\Excel\Concerns\ToModel;

class SchoolsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        if (!empty($row[0])) {
            return new School([
                'name' => $row[0],
                'region' => $row[1],
            ]);
        }
    
        // Jika kolom 'name' kosong, kembalikan null
        return null;
    }
}
