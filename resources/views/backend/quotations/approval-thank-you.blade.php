<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation Approved - Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: #27ae60;
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
        .success-icon {
            font-size: 80px;
            color: #27ae60;
            margin-bottom: 20px;
        }
        .message {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .quotation-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #27ae60;
        }
        .contact-info {
            background: #e3f2fd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .contact-info h3 {
            color: #1976d2;
            margin-top: 0;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 20px;
            font-size: 14px;
        }
        .auto-close {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #ffeaa7;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 Quotation Approved!</h1>
            <p>Thank you for your response</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="success-icon">✅</div>
            
            <div class="message">
                <h2>Thank You for Your Approval!</h2>
                <p>Your quotation has been successfully approved. Our team will review your approval and proceed with the next steps.</p>
            </div>

            @if(isset($quotation))
            <div class="quotation-info">
                <h3>Quotation Details</h3>
                <p><strong>Quotation Number:</strong> {{ $quotation->quotation_number }}</p>
                <p><strong>Client:</strong> {{ $quotation->client_business_name }}</p>
                <p><strong>Amount:</strong> {{ $quotation->formatted_final_amount }}</p>
                <p><strong>Approved on:</strong> {{ now()->format('d F, Y \a\t h:i A') }}</p>
            </div>
            @endif

            <div class="auto-close">
                <p><strong>Note:</strong> This page will automatically close in 10 seconds. You can close it manually if needed.</p>
            </div>

            <div class="contact-info">
                <h3>Need Assistance?</h3>
                <p>If you have any questions or need to make changes, please don't hesitate to contact us:</p>
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
            <p>We appreciate your business and look forward to working with you!</p>
        </div>
    </div>

    <script>
        // Auto-close the page after 10 seconds
        setTimeout(function() {
            window.close();
            // If window.close() doesn't work (due to browser restrictions), 
            // show a message to the user
            document.body.innerHTML += '<div style="position: fixed; top: 20px; right: 20px; background: #27ae60; color: white; padding: 15px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">✅ Approval successful! You can now close this window.</div>';
        }, 10000);

        // Also try to close after successful approval
        window.addEventListener('load', function() {
            // Log the approval for analytics (if needed)
            console.log('Quotation approved successfully');
        });
    </script>
</body>
</html>
