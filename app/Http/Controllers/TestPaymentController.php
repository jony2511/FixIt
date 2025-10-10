<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestPaymentController extends Controller
{
    /**
     * Test payment success callback
     */
    public function testSuccess(Request $request)
    {
        Log::info('Test Payment Success', [
            'method' => $request->method(),
            'all_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment callback received successfully',
            'method' => $request->method(),
            'data' => $request->all()
        ]);
    }
}