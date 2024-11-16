<?php

namespace App\Traits;

use App\Models\Building;
use App\Models\Flat;
use App\Models\Apartment;
use App\Models\Shop;
use App\Models\Office;
use Exception;

trait CodeGenerator
{
    public function generateNextCode()
    {
        $lastCode = $this->getLastCodeAcrossTables();

        if (!$lastCode) {
            return 'AA00001'; // Start from the first code if no code exists
        }

        $letters = substr($lastCode, 0, 2); // Get the two-letter part
        $number = (int)substr($lastCode, 2); // Get the numeric part

        $number += 1;

        if ($number > 99999) {
            $number = 1;
            $letters = $this->incrementLetters($letters);
        }

        return $letters . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    private function getLastCodeAcrossTables()
    {
        $buildingLastCode = Building::max('code');
        $flatLastCode = Flat::max('code');
        $apartmentLastCode = Apartment::max('code');
        $shopLastCode = Shop::max('code');
        $officeLastCode = Office::max('code');

        $codes = array_filter([$buildingLastCode, $flatLastCode, $apartmentLastCode, $shopLastCode, $officeLastCode]);

        return !empty($codes) ? max($codes) : null;
    }

    private function incrementLetters($letters)
    {
        $first = ord($letters[0]) - ord('A');
        $second = ord($letters[1]) - ord('A');

        $second += 1;

        if ($second > 25) {
            $second = 0;
            $first += 1;
        }

        if ($first > 25) {
            throw new Exception("No more codes available.");
        }

        return chr($first + ord('A')) . chr($second + ord('A'));
    }
}
