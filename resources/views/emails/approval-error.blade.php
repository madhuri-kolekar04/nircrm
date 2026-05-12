<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Error - NIRCRM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }
        .error-icon {
            font-size: 80px;
            margin: 20px 0;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            margin: 20px 10px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .footer {
            background: #34495e;
            color: white;
            padding: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="error-icon">❌</div>
            <h1>Approval Error</h1>
        </div>

        <div class="content">
            <p>We encountered an issue while processing your invoice approval.</p>
            
            <div class="error-message">
                <strong>Error Details:</strong><br>
                {{ $message }}
            </div>

            <div>
                <a href="tel:{{ $callNumber }}" class="btn">
                    📞 Call Support: {{ $callNumber }}
                </a>
            </div>

            <p style="margin-top: 30px; color: #666;">
                Please contact our support team for assistance with this approval.
            </p>
        </div>

        <div class="footer">
            <p>© 2026 NIRCRM Professional Business Solutions</p>
            <p>We apologize for the inconvenience.</p>
        </div>
    </div>
</body>
</html>
