<?php

use App\Models\Batch;
use App\Models\Box;
use App\Models\Coupon;

class ReportService
{
    public function summary()
    {
        return [
            'total_coupon'=>Coupon::count(),
            'total_batch'=>Batch::count(),
            'total_box'=>Box::count(),
            'total_prize'=>Coupon::sum('nominal')
        ];
    }
}