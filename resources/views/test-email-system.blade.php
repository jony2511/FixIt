<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email System Test - FixIt</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
        .header { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; padding: 40px; text-align: center; }
        .header h1 { font-size: 32px; margin-bottom: 10px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .content { padding: 40px; }
        .status-box { background: #f0f9ff; border-left: 4px solid #2563eb; padding: 20px; margin-bottom: 30px; border-radius: 8px; }
        .status-box h2 { color: #2563eb; margin-bottom: 10px; font-size: 20px; }
        .test-section { background: #f9fafb; padding: 25px; border-radius: 10px; margin-bottom: 20px; }
        .test-section h3 { color: #1f2937; margin-bottom: 15px; }
        .button { display: inline-block; background: #2563eb; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: all 0.3s; cursor: pointer; border: none; font-size: 16px; }
        .button:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); }
        .button:disabled { background: #9ca3af; cursor: not-allowed; }
        .result { margin-top: 20px; padding: 15px; border-radius: 8px; display: none; }
        .result.success { background: #dcfce7; border: 1px solid #10b981; color: #166534; }
        .result.error { background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; }
        .config-info { background: #fffbeb; border: 1px solid #fbbf24; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .config-info strong { color: #92400e; }
        .loading { display: none; text-align: center; padding: 20px; }
        .spinner { border: 4px solid #f3f4f6; border-top: 4px solid #2563eb; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 20px; }
        .info-card { background: white; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; }
        .info-card h4 { color: #2563eb; margin-bottom: 8px; font-size: 14px; }
        .info-card p { color: #6b7280; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 FixIt Email System Test</h1>
            <p>Test your email configuration and verify everything is working</p>
        </div>
        
        <div class="content">
            <div class="config-info">
                <h2 style="color: #92400e; margin-bottom: 15px;">✅ Email Configuration Loaded</h2>
                <div class="info-grid">
                    <div class="info-card">
                        <h4>Mail Driver</h4>
                        <p>SMTP (Gmail)</p>
                    </div>
                    <div class="info-card">
                        <h4>SMTP Host</h4>
                        <p>smtp.gmail.com:587</p>
                    </div>
                    <div class="info-card">
                        <h4>Your Email</h4>
                        <p>mdtarifulislamjony@gmail.com</p>
                    </div>
                    <div class="info-card">
                        <h4>From Address</h4>
                        <p>noreply@fixit.com</p>
                    </div>
                </div>
            </div>

            <div class="status-box">
                <h2>🎯 Quick Test</h2>
                <p>Click the button below to send a test email to your inbox. This will verify your Gmail SMTP configuration is working correctly.</p>
            </div>

            <div class="test-section">
                <h3>1. Send Test Email</h3>
                <p style="margin-bottom: 15px; color: #6b7280;">This will send a simple test email to mdtarifulislamjony@gmail.com</p>
                <button class="button" onclick="sendTestEmail()">Send Test Email</button>
                <div id="test-loading" class="loading">
                    <div class="spinner"></div>
                    <p style="margin-top: 10px; color: #6b7280;">Sending email...</p>
                </div>
                <div id="test-result" class="result"></div>
            </div>

            <div class="test-section">
                <h3>2. Test Password Reset Email</h3>
                <p style="margin-bottom: 15px; color: #6b7280;">Trigger a password reset email for your account</p>
                <a href="/forgot-password" class="button">Go to Forgot Password</a>
            </div>

            <div class="test-section">
                <h3>3. Test Payment Confirmation</h3>
                <p style="margin-bottom: 15px; color: #6b7280;">Place a test order to receive payment confirmation email with invoice PDF</p>
                <a href="/shop" class="button">Go to Shop</a>
            </div>

            <div style="background: #f0fdf4; border: 1px solid #10b981; padding: 20px; border-radius: 10px; margin-top: 30px;">
                <h3 style="color: #166534; margin-bottom: 10px;">📋 What to Check:</h3>
                <ul style="color: #166534; padding-left: 25px; line-height: 1.8;">
                    <li>Check your Gmail inbox for test email</li>
                    <li>Also check Spam/Junk folder</li>
                    <li>Email should arrive within 1-2 minutes</li>
                    <li>Payment emails will include PDF invoice attachment</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function sendTestEmail() {
            const button = event.target;
            const loading = document.getElementById('test-loading');
            const result = document.getElementById('test-result');
            
            button.disabled = true;
            loading.style.display = 'block';
            result.style.display = 'none';
            
            fetch('/test-email-config')
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    result.style.display = 'block';
                    
                    if (data.success) {
                        result.className = 'result success';
                        result.innerHTML = '<strong>✅ Success!</strong><br>' + data.message;
                    } else {
                        result.className = 'result error';
                        result.innerHTML = '<strong>❌ Error!</strong><br>' + data.message;
                    }
                    
                    button.disabled = false;
                })
                .catch(error => {
                    loading.style.display = 'none';
                    result.style.display = 'block';
                    result.className = 'result error';
                    result.innerHTML = '<strong>❌ Network Error!</strong><br>' + error.message;
                    button.disabled = false;
                });
        }
    </script>
</body>
</html>