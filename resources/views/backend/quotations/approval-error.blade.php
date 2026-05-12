<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Approval Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        .header {
            background: #e74c3c;
            color: white;
            padding: 40px 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .error-icon {
            font-size: 80px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        .message {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .error-details {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            color: #856404;
        }
        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .contact-info h3 {
            color: #495057;
            margin-top: 0;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 20px;
            font-size: 14px;
        }
        .auto-close {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>❌ Approval Error</h1>
            <p>Unable to process your request</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="error-icon">⚠️</div>
            
            <div class="message">
                <h2>{{ $error ?? 'Approval Failed' }}</h2>
                <p>{{ $message ?? 'An error occurred while processing your approval request.' }}</p>
            </div>

            <div class="error-details">
                <h3>What might have happened?</h3>
                <ul style="text-align: left; max-width: 400px; margin: 0 auto;">
                    <li>The approval link has expired</li>
                    <li>The quotation has already been approved or rejected</li>
                    <li>You're not authorized to approve this quotation</li>
                    <li>The link was corrupted or modified</li>
                </ul>
            </div>

            <div class="auto-close">
                <p><strong>Note:</strong> This page will automatically close in 10 seconds. You can close it manually if needed.</p>
            </div>

            <div class="contact-info">
                <h3>Need Assistance?</h3>
                <p>If you believe this is an error or need assistance with your quotation, please contact us:</p>
                <p>
                    📞 <strong>Phone:</strong> +91-9220518202<br>
                    📧 <strong>Email:</strong> udyami.nircrm24@gmail.com<br>
                    🌐 <strong>Website:</strong> www.nircrm.com
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>NIRCRM - Digital Solutions</strong></p>
            <p>We apologize for any inconvenience caused.</p>
        </div>
    </div>

    <script>
        // Auto-close the page after 10 seconds
        setTimeout(function() {
            window.close();
            // If window.close() doesn't work (due to browser restrictions), 
            // show a message to the user
            document.body.innerHTML += '<div style="position: fixed; top: 20px; right: 20px; background: #e74c3c; color: white; padding: 15px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">❌ Approval failed! You can now close this window.</div>';
        }, 10000);

        // Also try to close after error
        window.addEventListener('load', function() {
            // Log the error for analytics (if needed)
            console.error('Quotation approval error:', '{{ $error ?? "Unknown error" }}');
        });
    </script>
</body>
</html>
