<?php

namespace App\Services;

class CouponNumberGenerator
{
    public function generate(int $boxNumber): array
    {
        $start = (($boxNumber - 1) * 1000) + 1;
        $end = $start + 999;

        $numbers = [];
        for ($i = $start; $i <= $end; $i++) {
            $numbers[] = str_pad($i, 5, '0', STR_PAD_LEFT);
        }

        shuffle($numbers);

        return $numbers;
    }
}