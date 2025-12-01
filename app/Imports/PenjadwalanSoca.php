<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenjadwalanSoca implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // var_dump($row['nim']);
            // You can process manually, for example:
            // \DB::table('mahasiswa')->insert([
            //     'nim'         => $row['nim'],
            //     'nama'        => $row['nama'],
            //     'tahunmasuk'  => $row['tahunmasuk'],
            // ]);
        }
        // die;
    }
}
