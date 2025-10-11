<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SSLCommerzService
{
    protected $storeId;
    protected $storePassword;
    protected $apiUrl;
    protected $mode;

    public function __construct()
    {
        $this->storeId = config('services.sslcommerz.store_id');
        $this->storePassword = config('services.sslcommerz.store_password');
        $this->apiUrl = config('services.sslcommerz.api_url');
        $this->mode = config('services.sslcommerz.mode');
        
        // Debug: Log credentials being used (remove in production)
        Log::info('SSLCommerz Configuration', [
            'store_id' => $this->storeId,
            'store_password' => substr($this->storePassword, 0, 3) . '***', // Partially hidden
            'api_url' => $this->apiUrl,
            'mode' => $this->mode
        ]);
    }

    /**
     * Initialize payment session with SSLCommerz
     */
    public function initiatePayment($orderData)
    {
        $postData = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $orderData['total_amount'],
            'currency' => $orderData['currency'] ?? 'BDT',
            'tran_id' => $orderData['transaction_id'],
            'success_url' => route('payment.success'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
            'ipn_url' => route('payment.ipn'),
            
            // Customer Information
            'cus_name' => $orderData['customer_name'],
            'cus_email' => $orderData['customer_email'],
            'cus_add1' => $orderData['customer_address'],
            'cus_city' => $orderData['customer_city'],
            'cus_postcode' => $orderData['customer_postcode'] ?? '1000',
            'cus_country' => $orderData['customer_country'] ?? 'Bangladesh',
            'cus_phone' => $orderData['customer_phone'],
            
            // Shipment Information
            'shipping_method' => $orderData['shipping_method'] ?? 'NO',
            'ship_name' => $orderData['customer_name'],
            'ship_add1' => $orderData['customer_address'],
            'ship_city' => $orderData['customer_city'],
            'ship_postcode' => $orderData['customer_postcode'] ?? '1000',
            'ship_country' => $orderData['customer_country'] ?? 'Bangladesh',
            
            // Product Information
            'product_name' => $orderData['product_name'] ?? 'Order Items',
            'product_category' => $orderData['product_category'] ?? 'General',
            'product_profile' => 'general',
            
            // Additional Fields
            'value_a' => $orderData['order_id'] ?? '',
            'value_b' => $orderData['user_id'] ?? '',
            'value_c' => $orderData['notes'] ?? '',
            'value_d' => '',
        ];

        try {
            $response = Http::asForm()->post(
                $this->apiUrl . '/gwprocess/v4/api.php',
                $postData
            );

            $result = $response->json();

            Log::info('SSLCommerz Payment Initiation', [
                'transaction_id' => $orderData['transaction_id'],
                'response' => $result
            ]);

            if (isset($result['status']) && $result['status'] === 'SUCCESS') {
                return [
                    'success' => true,
                    'gateway_url' => $result['GatewayPageURL'],
                    'session_key' => $result['sessionkey'] ?? null,
                    'data' => $result
                ];
            }

            return [
                'success' => false,
                'message' => $result['failedreason'] ?? 'Payment initiation failed',
                'data' => $result
            ];

        } catch (\Exception $e) {
            Log::error('SSLCommerz Payment Error', [
                'error' => $e->getMessage(),
                'transaction_id' => $orderData['transaction_id']
            ]);

            return [
                'success' => false,
                'message' => 'Payment service unavailable. Please try again later.',
                'data' => null
            ];
        }
    }

    /**
     * Validate payment response from SSLCommerz
     */
    public function validatePayment($validationData)
    {
        try {
            $response = Http::get($this->apiUrl . '/validator/api/validationserverAPI.php', [
                'val_id' => $validationData['val_id'],
                'store_id' => $this->storeId,
                'store_passwd' => $this->storePassword,
                'format' => 'json'
            ]);

            $result = $response->json();

            Log::info('SSLCommerz Payment Validation', [
                'val_id' => $validationData['val_id'],
                'response' => $result
            ]);

            if (isset($result['status']) && $result['status'] === 'VALID') {
                return [
                    'success' => true,
                    'data' => $result
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment validation failed',
                'data' => $result
            ];

        } catch (\Exception $e) {
            Log::error('SSLCommerz Validation Error', [
                'error' => $e->getMessage(),
                'val_id' => $validationData['val_id'] ?? null
            ]);

            return [
                'success' => false,
                'message' => 'Payment validation failed',
                'data' => null
            ];
        }
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus($transactionId)
    {
        try {
            $response = Http::get($this->apiUrl . '/validator/api/merchantTransIDvalidationAPI.php', [
                'tran_id' => $transactionId,
                'store_id' => $this->storeId,
                'store_passwd' => $this->storePassword,
                'format' => 'json'
            ]);

            $result = $response->json();

            Log::info('SSLCommerz Transaction Status Check', [
                'transaction_id' => $transactionId,
                'response' => $result
            ]);

            return [
                'success' => true,
                'data' => $result
            ];

        } catch (\Exception $e) {
            Log::error('SSLCommerz Status Check Error', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId
            ]);

            return [
                'success' => false,
                'message' => 'Status check failed',
                'data' => null
            ];
        }
    }

    /**
     * Initiate refund
     */
    public function initiateRefund($refundData)
    {
        $postData = [
            'refund_amount' => $refundData['refund_amount'],
            'refund_remarks' => $refundData['refund_remarks'] ?? 'Customer refund request',
            'bank_tran_id' => $refundData['bank_tran_id'],
            'refe_id' => $refundData['refe_id'],
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
        ];

        try {
            $response = Http::asForm()->post(
                $this->apiUrl . '/validator/api/merchantTransIDvalidationAPI.php',
                $postData
            );

            $result = $response->json();

            Log::info('SSLCommerz Refund Initiation', [
                'bank_tran_id' => $refundData['bank_tran_id'],
                'response' => $result
            ]);

            return [
                'success' => isset($result['APIConnect']) && $result['APIConnect'] === 'DONE',
                'data' => $result
            ];

        } catch (\Exception $e) {
            Log::error('SSLCommerz Refund Error', [
                'error' => $e->getMessage(),
                'bank_tran_id' => $refundData['bank_tran_id'] ?? null
            ]);

            return [
                'success' => false,
                'message' => 'Refund initiation failed',
                'data' => null
            ];
        }
    }
}
