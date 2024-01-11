<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class MultisheeStudentImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            'Anh9NC' => new StudentImport(),
            ];
    }
}
