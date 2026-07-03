<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CouponGeneratorService;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function generate(CouponGeneratorService $service)
    {
        $service->generate();

        return response()->json([
            'message' => '10.000 kupon berhasil digenerate'
        ]);
    }

    public function report()
    {
        $details = DB::table('coupons as c')
            ->join('boxes as b', 'b.id', '=', 'c.box_id')
            ->join('batches as bat', 'bat.id', '=', 'b.batch_id')
            ->join('production_logs as pl', 'pl.batch_id', '=', 'bat.id')
            ->join('users as u', 'u.id', '=', 'pl.user_id')
            ->join('locations as l', 'l.id', '=', 'bat.locations_id')
            ->select(
                'bat.batch_number',
                'u.name as operator_name',
                'l.location_name as location_name',
                'pl.updated_at as tanggal',
                'b.box_number',
                'c.coupon_number',
                'c.prize',
                'c.remarks',
            )
            ->orderBy('bat.batch_number')
            ->orderBy('b.box_number')
            ->orderBy('c.coupon_number')
            ->get();
        
        $details = $details->groupBy('batch_number');

        return view('report', compact('details'));
    }
}
