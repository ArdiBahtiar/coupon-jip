<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Box;
use App\Models\Coupon;
use App\Models\ProductionLog;
use App\Services\CouponNumberGenerator;
use App\Services\PrizeAllocatorService;
use Illuminate\Support\Facades\DB;

class CouponGeneratorService
{
    public function __construct(
        private CouponNumberGenerator $numberGenerator,
        private PrizeAllocatorService $prizeAllocator,
    ) {}

    public function generate(): void
    {
        DB::transaction(function () {

            Coupon::query()->delete();
            Box::query()->delete();
            ProductionLog::query()->delete();
            Batch::query()->delete();

            $now = now();

            for ($batchNo = 1; $batchNo <= 2; $batchNo++) {
                $batch = $this->createBatch($batchNo, $now);

                for ($boxNo = 1; $boxNo <= 5; $boxNo++) {
                    $globalBoxNo = (($batchNo - 1) * 5) + $boxNo;
                    $this->createBox($batch, $globalBoxNo, $boxNo);
                }
            }
        });
    }

    private function createBatch(int $batchNo, $now): Batch
    {
        $batch = Batch::create([
            'user_id' => $batchNo,
            'batch_number' => $batchNo,
            'locations_id' => $batchNo,
            'started_at' => $now,
            'finished_at' => $now,
        ]);

        ProductionLog::create([
            'batch_id' => $batch->id,
            'user_id' => $batch->user_id,
        ]);

        return $batch;
    }

    private function createBox(Batch $batch, int $globalBoxNo, int $now): void
    {
        $box = Box::create([
            'batch_id' => $batch->id,
            'box_number' => $globalBoxNo
        ]);

        $couponNumbers = $this->numberGenerator->generate($globalBoxNo);
        $prizes = $this->prizeAllocator->generate();

        $rows = [];
        foreach ($couponNumbers as $index => $couponNumber) {
            $prize = $prizes[$index];
            $rows[] = [
                'coupon_number' => $couponNumber,
                'prize' => $prize,
                'box_id' => $box->id,
                'remarks' => $prize == 0 ? 'Anda Belum Beruntung' : null,
            ];
        }

        Coupon::insert($rows);
    }
}