<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatePaymentRequest;
use App\Processors\PriceCalculationProcessor;

class PaymentController extends Controller
{
    public function __invoke(
        CalculatePaymentRequest $request,
        PriceCalculationProcessor $processor
    ): int
    {
        return $processor->process($request->get('reservation_id'));
    }
}
