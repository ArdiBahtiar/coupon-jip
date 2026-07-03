<?php

namespace App\Services;

class PrizeAllocatorService
{
    /** @var array<int,int> nilai hadiah => jumlah per box */
    private array $prizeCounts = [
        5000   => 100,
        10000  => 50,
        20000  => 25,
        50000  => 10,
        100000 => 5,
    ];

    private int $totalSlots = 1000;

    public function generate(): array
    {
        $prizes = $this->buildPrizeList();
        shuffle($prizes);

        $slots = array_fill(0, $this->totalSlots, 0);

        foreach ($prizes as $prize) {
            $position = $this->findPosition($slots, $prize);
            $slots[$position] = $prize;
        }

        return $slots;
    }

    private function buildPrizeList(): array
    {
        $prizes = [];
        foreach ($this->prizeCounts as $prize => $count) {
            $prizes = array_merge($prizes, array_fill(0, $count, $prize));
        }
        return $prizes;
    }

    private function findPosition(array $slots, int $prize): int
    {
        $maxAttempts = 5000;
        $attempts = 0;

        do {
            $position = rand(0, $this->totalSlots - 1);
            $attempts++;

            if ($attempts > $maxAttempts) {
                // jaga-jaga: fallback linear search biar tidak mungkin infinite loop lagi
                return $this->findFirstFit($slots, $prize);
            }
        } while (
            $slots[$position] != 0 ||
            ($position > 0 && $slots[$position - 1] == $prize) ||
            ($position < $this->totalSlots - 1 && $slots[$position + 1] == $prize)
        );

        return $position;
    }

    private function findFirstFit(array $slots, int $prize): int
    {
        foreach ($slots as $i => $value) {
            if ($value != 0) continue;
            $leftOk  = $i === 0 || $slots[$i - 1] != $prize;
            $rightOk = $i === $this->totalSlots - 1 || $slots[$i + 1] != $prize;
            if ($leftOk && $rightOk) return $i;
        }

        foreach ($slots as $i => $value) {
            if ($value == 0) return $i;
        }

        throw new \RuntimeException('Tidak ada slot kosong tersisa.');
    }
}