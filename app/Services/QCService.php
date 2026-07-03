<?php

class QCService
{
    public function validate($batches)
    {
        $this->validateCouponCount();
        $this->validatePrizeDistribution();
        $this->validateBoxComposition();
        $this->validateAdjacentPrize();
        $this->validateUniqueCoupon();
    }
}