<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .company-info {
            text-align: left;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .company-details {
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }
        
        .invoice-title {
            text-align: right;
            margin-top: -60px;
        }
        
        .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .invoice-date {
            font-size: 14px;
            color: #666;
        }
        
        .billing-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .billing-from, .billing-to {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .billing-to {
            text-align: right;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .customer-info {
            font-size: 14px;
            line-height: 1.8;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th {
            background-color: #f8fafc;
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }
        
        .items-table td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            vertical-align: top;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-section {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        
        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .total-label {
            display: table-cell;
            font-weight: bold;
            padding: 8px;
        }
        
        .total-amount {
            display: table-cell;
            text-align: right;
            padding: 8px;
        }
        
        .grand-total {
            border-top: 2px solid #2563eb;
            background-color: #f8fafc;
        }
        
        .grand-total .total-label,
        .grand-total .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .payment-info {
            clear: both;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .payment-method {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .transaction-id {
            font-size: 12px;
            color: #666;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-completed {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-processing {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-pending {
            background-color: #e0e7ff;
            color: #3730a3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <div class="company-name">FixIt Solutions</div>
            <div class="company-details">
                Professional Repair & E-commerce Services<br>
                Email: info@fixit.com | Phone: +880 1234-567890<br>
                Address: 123 Tech Street, Dhaka, Bangladesh
            </div>
        </div>
        <div class="invoice-title">
            <div class="invoice-number">INVOICE #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="invoice-date">Date: {{ $order->created_at->format('F d, Y') }}</div>
        </div>
    </div>

    <!-- Billing Information -->
    <div class="billing-info">
        <div class="billing-from">
            <div class="section-title">Bill From</div>
            <div class="customer-info">
                <strong>FixIt Solutions</strong><br>
                123 Tech Street<br>
                Dhaka 1000, Bangladesh<br>
                Email: info@fixit.com<br>
                Phone: +880 1234-567890
            </div>
        </div>
        <div class="billing-to">
            <div class="section-title">Bill To</div>
            <div class="customer-info">
                <strong>{{ $order->shipping_name ?? $order->user->name }}</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}<br>
                Email: {{ $order->shipping_email ?? $order->user->email }}<br>
                Phone: {{ $order->shipping_phone }}
            </div>
        </div>
    </div>

    <!-- Order Information -->
    <div style="margin-bottom: 30px;">
        <div class="section-title">Order Information</div>
        <p style="margin: 0; font-size: 14px; line-height: 1.8;">
            <strong>Order ID:</strong> #{{ $order->id }}<br>
            <strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}<br>
            <strong>Payment Method:</strong> {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}
            @if($order->transaction_id)
                <br><strong>Transaction ID:</strong> {{ $order->transaction_id }}
            @endif
            <br><strong>Status:</strong> 
            <span class="status-badge status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
        </p>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 50%;">Product Name</th>
                <th style="width: 15%;" class="text-center">Quantity</th>
                <th style="width: 15%;" class="text-right">Unit Price</th>
                <th style="width: 10%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->product->name }}</strong>
                    @if($item->product->description)
                        <br><small style="color: #666;">{{ Str::limit($item->product->description, 100) }}</small>
                    @endif
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Tk.{{ number_format($item->price, 2) }}</td>
                <td class="text-right">Tk.{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total Section -->
    <div class="total-section">
        @php
            $subtotal = $order->subtotal_amount ?? $order->orderItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
            $shipping = $order->shipping_amount ?? 0;
            $tax = 0; // No tax for now
        @endphp
        
        <div class="total-row">
            <div class="total-label">Subtotal:</div>
            <div class="total-amount">Tk.{{ number_format($subtotal, 2) }}</div>
        </div>
        
        <div class="total-row">
            <div class="total-label">Shipping:</div>
            @if($shipping > 0)
                <div class="total-amount">Tk.{{ number_format($shipping, 2) }}</div>
            @else
                <div class="total-amount" style="color: #16a34a;">FREE</div>
            @endif
        </div>
        
        @if($tax > 0)
        <div class="total-row">
            <div class="total-label">Tax:</div>
            <div class="total-amount">Tk.{{ number_format($tax, 2) }}</div>
        </div>
        @endif
        
        <div class="total-row grand-total">
            <div class="total-label">Grand Total:</div>
            <div class="total-amount">Tk.{{ number_format($order->total_amount, 2) }}</div>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="payment-info">
        <div class="section-title">Payment Information</div>
        <div class="payment-method">
            <strong>Payment Method:</strong> 
            @if($order->payment_method === 'cod')
                Cash on Delivery
            @else
                Online Payment (SSLCommerz)
            @endif
        </div>
        @if($order->transaction_id)
            <div class="transaction-id">
                <strong>Transaction ID:</strong> {{ $order->transaction_id }}
            </div>
        @endif
        <div style="margin-top: 10px; font-size: 12px;">
            @if($order->payment_status === 'paid')
                <span style="color: #16a34a;">✓ Payment Confirmed</span>
            @elseif($order->payment_method === 'cod' && in_array($order->order_status, ['processing', 'confirmed']))
                <span style="color: #ea580c;">◯ Payment Pending (COD)</span>
            @else
                <span style="color: #dc2626;">◯ Payment Pending</span>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>
            For any questions about this invoice, please contact us at:<br>
            Email: support@fixit.com | Phone: +880 1234-567890
        </p>
        <p style="margin-top: 20px; font-size: 10px;">
            This is a computer-generated invoice. No signature required.
        </p>
    </div>
</body>
</html>