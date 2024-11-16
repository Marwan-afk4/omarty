<?php

namespace App\Traits;

use App\Models\Building;
use App\Models\Flat;
use App\Models\Apartment;
use App\Models\Shop;
use App\Models\Office;
use App\Models\User;
use Exception;

trait CodeGeneratorforUsers
{
    public function generateNextCode() {
        $lastCode = User::max('user_code');

        if (!$lastCode) {
            return 'AA0001';
        }

        $letters = substr($lastCode, 0, 2); // Get the two-letter part
        $number = (int)substr($lastCode, 2); // Get the numeric part

        $number += 1;

        if ($number > 9999) {
            $number = 1;
            $letters = $this->incrementLetters($letters); // Move to the next letter sequence
        }

        return $letters . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function incrementLetters($letters) {
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
