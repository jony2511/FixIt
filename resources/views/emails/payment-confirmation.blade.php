<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); padding: 40px 30px; text-align: center; border-radius: 10px 10px 0 0;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: bold;">FixIt Solutions</h1>
                            <p style="margin: 10px 0 0 0; color: #e0e7ff; font-size: 14px;">Professional Repair & E-commerce Services</p>
                        </td>
                    </tr>
                    
                    <!-- Success Icon -->
                    <tr>
                        <td align="center" style="padding: 30px 0 20px 0;">
                            <div style="width: 80px; height: 80px; background-color: #10b981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                <span style="color: #ffffff; font-size: 48px; font-weight: bold;">✓</span>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Main Message -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px; text-align: center;">
                            <h2 style="margin: 0 0 20px 0; color: #10b981; font-size: 28px; font-weight: bold;">Payment Successful!</h2>
                            <p style="margin: 0 0 10px 0; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Dear <strong>{{ $order->shipping_name ?? $order->user->name }}</strong>,
                            </p>
                            <p style="margin: 0; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                Thank you for your payment! We have successfully received your payment of <strong style="color: #2563eb;">Tk.{{ number_format($order->total_amount, 2) }}</strong> and your order is now being processed.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Order Details -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; padding: 20px;">
                                <tr>
                                    <td colspan="2" style="padding-bottom: 15px;">
                                        <h3 style="margin: 0; color: #2563eb; font-size: 18px; font-weight: bold;">Order Summary</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #4b5563; font-weight: bold;">Order Number:</td>
                                    <td style="padding: 8px 0; color: #1f2937; text-align: right;">#{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #4b5563; font-weight: bold;">Order Date:</td>
                                    <td style="padding: 8px 0; color: #1f2937; text-align: right;">{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #4b5563; font-weight: bold;">Payment Method:</td>
                                    <td style="padding: 8px 0; color: #1f2937; text-align: right;">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment (SSLCommerz)' }}</td>
                                </tr>
                                @if($order->transaction_id)
                                <tr>
                                    <td style="padding: 8px 0; color: #4b5563; font-weight: bold;">Transaction ID:</td>
                                    <td style="padding: 8px 0; color: #1f2937; text-align: right; font-size: 12px;">{{ $order->transaction_id }}</td>
                                </tr>
                                @endif
                                <tr style="border-top: 2px solid #e5e7eb;">
                                    <td style="padding: 15px 0 0 0; color: #2563eb; font-weight: bold; font-size: 18px;">Total Amount:</td>
                                    <td style="padding: 15px 0 0 0; color: #2563eb; font-weight: bold; font-size: 18px; text-align: right;">Tk.{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Order Items -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px; font-weight: bold;">Items Ordered</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                                @foreach($order->orderItems as $index => $item)
                                <tr style="{{ $index % 2 == 0 ? 'background-color: #f9fafb;' : 'background-color: #ffffff;' }}">
                                    <td style="padding: 15px;">
                                        <strong style="color: #1f2937;">{{ $item->product->name }}</strong>
                                        <br>
                                        <span style="color: #6b7280; font-size: 13px;">Qty: {{ $item->quantity }} × Tk.{{ number_format($item->price, 2) }}</span>
                                    </td>
                                    <td style="padding: 15px; text-align: right;">
                                        <strong style="color: #1f2937;">Tk.{{ number_format($item->price * $item->quantity, 2) }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Shipping Details -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #eff6ff; border-radius: 8px; padding: 20px; border-left: 4px solid #2563eb;">
                                <tr>
                                    <td>
                                        <h3 style="margin: 0 0 10px 0; color: #2563eb; font-size: 16px; font-weight: bold;">Shipping Information</h3>
                                        <p style="margin: 5px 0; color: #1f2937; font-size: 14px;"><strong>Name:</strong> {{ $order->shipping_name }}</p>
                                        <p style="margin: 5px 0; color: #1f2937; font-size: 14px;"><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                                        <p style="margin: 5px 0; color: #1f2937; font-size: 14px;"><strong>Email:</strong> {{ $order->shipping_email }}</p>
                                        <p style="margin: 5px 0; color: #1f2937; font-size: 14px;"><strong>Address:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- What's Next -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fef3c7; border-radius: 8px; padding: 20px; border-left: 4px solid #f59e0b;">
                                <tr>
                                    <td>
                                        <h3 style="margin: 0 0 10px 0; color: #f59e0b; font-size: 16px; font-weight: bold;">What's Next?</h3>
                                        <ul style="margin: 10px 0; padding-left: 20px; color: #78350f; font-size: 14px; line-height: 1.8;">
                                            <li>Your order is now being processed by our team</li>
                                            <li>You'll receive tracking information once your order ships</li>
                                            <li>Estimated delivery: 3-5 business days</li>
                                            <li>Track your order anytime from your account dashboard</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Invoice Note -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px; text-align: center;">
                            <div style="background-color: #dcfce7; border-radius: 8px; padding: 15px; display: inline-block;">
                                <p style="margin: 0; color: #166534; font-size: 14px;">
                                    <strong>📎 Invoice Attached</strong><br>
                                    <span style="font-size: 13px;">Your detailed invoice is attached to this email as a PDF file.</span>
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- CTA Buttons -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px; text-align: center;">
                            <a href="{{ route('user.orders.show', $order->id) }}" style="display: inline-block; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 6px; font-weight: bold; margin: 5px;">View Order Details</a>
                            <a href="{{ route('shop.index') }}" style="display: inline-block; background-color: #6b7280; color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 6px; font-weight: bold; margin: 5px;">Continue Shopping</a>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px 40px; text-align: center; border-radius: 0 0 10px 10px; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 15px 0; color: #6b7280; font-size: 14px;">
                                Need help? Contact us at:<br>
                                <a href="mailto:support@fixit.com" style="color: #2563eb; text-decoration: none;">support@fixit.com</a> | 
                                <a href="tel:+8801234567890" style="color: #2563eb; text-decoration: none;">+880 1234-567890</a>
                            </p>
                            <p style="margin: 0 0 15px 0; color: #1f2937; font-size: 13px;">
                                <strong>FixIt Solutions</strong><br>
                                123 Tech Street, Dhaka 1000, Bangladesh
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 11px;">
                                © {{ date('Y') }} FixIt Solutions. All rights reserved.<br>
                                This email was sent to {{ $order->shipping_email ?? $order->user->email }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>