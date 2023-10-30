<?php

namespace App\Helpers\CSV_parser;

use Illuminate\Support\Facades\DB;

class Csv_parser
{
    function csvToArray($filename = '', $delimiter = ','): bool|array
    {

        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function importCsv(): string
    {
        $file = __DIR__ . '/data/categories.csv';

        $customerArr = $this->csvToArray($file);

        for ($i = 0; $i < count($customerArr); $i++) {
            DB::table('categories')->insert($customerArr[$i]);
        }

        return 'Job is done';
    }

}
