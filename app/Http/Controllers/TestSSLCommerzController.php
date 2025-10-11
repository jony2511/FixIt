<?php

namespace App\Http\Controllers;

use App\Services\SSLCommerzService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestSSLCommerzController extends Controller
{
    public function testCredentials()
    {
        $sslcommerz = new SSLCommerzService();
        
        // Test data for SSLCommerz
        $testData = [
            'total_amount' => 100,
            'currency' => 'BDT',
            'transaction_id' => 'TEST_' . time(),
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com',
            'customer_address' => 'Test Address',
            'customer_city' => 'Dhaka',
            'customer_phone' => '01700000000',
            'product_name' => 'Test Product',
        ];
        
        try {
            $result = $sslcommerz->initiatePayment($testData);
            
            return response()->json([
                'success' => $result['success'] ?? false,
                'message' => $result['success'] ? 'SSLCommerz credentials are working!' : ($result['message'] ?? 'Unknown error'),
                'data' => $result['data'] ?? null
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ]);
        }
    }
}