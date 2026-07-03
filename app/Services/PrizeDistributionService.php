<?php

namespace App\Services;
use App\Models\Batch;
use App\Models\Box;
use App\Models\Coupon;
use App\Models\ProductionLog;
use Illuminate\Support\Facades\DB;

{
    public function generate()
    {
        DB::transaction(function () {

            // RESET DATA
            Coupon::truncate();
            Box::truncate();
            Batch::truncate();
            ProductionLog::truncate();

            /*
             * DISTRIBUSI HADIAH PER BOX
             *
             * 50 x 100.000 => 5 per box
             * 100 x 50.000 => 10 per box
             * 250 x 20.000 => 25 per box
             * 500 x 10.000 => 50 per box
             * 1000 x 5.000 => 100 per box
             *
             * Total hadiah per box = 190
             * Sisanya = 810 kupon kosong
             */

            $boxComposition = array_merge(
                array_fill(0, 5, 100000),
                array_fill(0, 10, 50000),
                array_fill(0, 25, 20000),
                array_fill(0, 50, 10000),
                array_fill(0, 100, 5000),
                array_fill(0, 810, 0)
            );

            // buat 2 batch
            for ($batchNo = 1; $batchNo <= 2; $batchNo++) {

                $batch = Batch::create([
                    'user_id' => $batchNo,
                    'location_id' => 1,
                    'started_at' => now(),
                    'finished_at' => now(),
                ]);

                ProductionLog::create([
                    'batch_id' => $batch->id,
                    'user_id' => $batch->user_id,
                ]);

                // tiap batch 5 box
                for ($i = 1; $i <= 5; $i++) {

                    $globalBoxNo = (($batchNo - 1) * 5) + $i;

                    $box = Box::create([
                        'batch_id' => $batch->id
                    ]);

                    $prizes = $this->shuffleWithoutConsecutivePrize(
                        $boxComposition
                    );

                    $numbers = [];

                    $start = (($globalBoxNo - 1) * 1000) + 1;
                    $end = $start + 999;

                    for ($n = $start; $n <= $end; $n++) {
                        $numbers[] = str_pad($n, 5, '0', STR_PAD_LEFT);
                    }

                    shuffle($numbers);

                    foreach ($numbers as $index => $couponNumber) {

                        $prize = $prizes[$index];

                        Coupon::create([
                            'coupon_number' => $couponNumber,
                            'prize' => $prize,
                            'box_id' => $box->id,
                            'remarks' => $prize == 0
                                ? 'Anda Belum Beruntung'
                                : null
                        ]);
                    }
                }
            }
        });
    }

    private function shuffleWithoutConsecutivePrize(array $prizes)
    {
        do {
            shuffle($prizes);

            $valid = true;

            for ($i = 1; $i < count($prizes); $i++) {

                if (
                    $prizes[$i] != 0 &&
                    $prizes[$i] == $prizes[$i - 1]
                ) {
                    $valid = false;
                    break;
                }
            }

        } while (!$valid);

        return $prizes;
    }
}

