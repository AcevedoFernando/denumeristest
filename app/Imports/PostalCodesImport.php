<?php

namespace App\Imports;

use App\Models\PostalCode;
use Maatwebsite\Excel\Concerns\ToModel;

class PostalCodesImport implements ToModel
{

    //   Excel File Headers
    //   0 => "d_codigo"
    //   1 => "d_asenta"
    //   2 => "d_tipo_asenta"
    //   3 => "D_mnpio"
    //   4 => "d_estado"
    //   5 => "d_ciudad"
    //   6 => "d_CP"
    //   7 => "c_estado"
    //   8 => "c_oficina"
    //   9 => "c_CP" => null
    //   10 => "c_tipo_asenta"
    //   11 => "c_mnpio"
    //   12 => "id_asenta_cpcons"
    //   13 => "d_zona"
    //   14 => "c_cve_ciudad"

    private $skippedHeaders = false;
    private $headers = [];
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!$this->skippedHeaders) {
            $this->skippedHeaders = true;
            $this->headers = $row;
        } else {
            return new PostalCode([
                'code' => $row[0],
                'suburb' => $row[1],
                'suburb_type' => $row[2],
                'township' => $row[3],
                'state' => $row[4],
                'city' => $row[5],
                'cp' => $row[6],
                'state_code' => $row[7],
                'office_code' => $row[8],
                'township_code' => $row[10],
                'suburb_code' => $row[11],
                'zone' => $row[12],
                'city_code' => $row[13]
            ]);
        }
    }
}
