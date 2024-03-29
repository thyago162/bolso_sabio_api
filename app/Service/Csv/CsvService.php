<?php

namespace App\Service\Csv;

use Normalizer;

class CsvService
{
    public function csvToArray($arquivo)
    {
        if (($handle = fopen($arquivo, 'r')) !== FALSE) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, ';', '"')) !== FALSE) {
                for ($j = 0; $j < count($lineArray); $j++) {
                    $arr[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }

        return $arr;
    }
    public function montarArray($data)
    {
        array_shift($data);
        $count = count($data) - 1;
        $labels = array_shift($data);

        foreach ($labels as $label) {
            $normalized = Normalizer::normalize($label, Normalizer::NFD);
            $texto = preg_replace('/[\x{0300}-\x{036F}]/u', '', $normalized);
            $keys[] = strtolower(str_replace(' ', '_', $texto));
        }

        for ($j = 0; $j < $count; $j++) {
            $d = array_combine($keys, $data[$j]);
            $newArray[$j] = $d;
        }

        return $newArray;
    }
}
