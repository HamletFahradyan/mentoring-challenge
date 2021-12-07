<?php
declare(strict_types=1);

namespace App\Services;


class CSVFileService
{
    /**
     * @param $file
     * @return array
     */
    public function getArray($file): array
    {
        $lines = explode("\n", file_get_contents($file->getPathName()));
        $headers = str_getcsv(array_shift($lines));
        $data = array();

        foreach ($lines as $line) {
            $row = array();

            foreach (str_getcsv($line) as $key => $field) {
                $row[$headers[$key]] = $field;
            }

            $row = array_filter($row);

            if (!isset($row['Timezone'])) {
                $row['Timezone'] = "0";
            }
            if (!empty($row)){
                $row['Matched'] = false;
            }
            if (isset($row['Division'])) {
                $data[] = $row;
            }
        }

        return array_filter($data);
    }
}
