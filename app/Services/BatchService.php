<?php

use App\Models\Batch;
use App\Models\Box;
use Illuminate\Support\Collection;

class BatchService
{
    public function createProduction(Collection $distribution)
    {
        $batches = $this->createBatch();
        $boxes = $this->createBoxes($batches);
        $this->assignCoupon(
            $boxes,
            $distribution
        );
        return $batches;
    }

    protected function createBatch()
    {
        return collect([
            Batch::create([
                'batch_number'=>1,
                'user_id'=>1,
                'location_id'=>'Surabaya'
            ]),

            Batch::create([
                'batch_number'=>2,
                'user_id'=>2,
                'location_id'=>'Surabaya'
            ])
        ]);
    }

    protected function createBoxes(Collection $batches)
    {
        // batch id
        return collect([
            Box::create([
                'box_id'
            ])
        ]);
    }

    protected function assignCoupon()
    {
        foreach($boxes as $box){
            // insert 1000 coupon
        }
    }
}