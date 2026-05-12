<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Proposal - {{ $quotation->quotation_number }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background: #f8f9fa;">
    <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: #3498db; color: white; padding: 30px; text-align: center;">
            <h1 style="margin: 0; font-size: 28px;">Business Proposal</h1>
            <p style="margin: 10px 0 0 0;">Professional Services for {{ $quotation->client_business_name }}</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <!-- Quotation Details -->
            <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 8px;">Proposal Details</h3>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <p><strong>Proposal Number:</strong> {{ $quotation->quotation_number }}</p>
                <p><strong>Date:</strong> {{ $quotation->created_at->format('d F, Y') }}</p>
                <p><strong>Valid Until:</strong> {{ $quotation->valid_until ? $quotation->valid_until->format('d F, Y') : 'N/A' }}</p>
                <p><strong>Client:</strong> {{ $quotation->client_business_name }}</p>
                <p><strong>Contact Person:</strong> {{ $quotation->client_contact_name }}</p>
            </div>

            <!-- Services -->
            <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 8px;">Proposed Services</h3>
            @foreach($quotation->services as $service)
            <div style="background: white; border: 1px solid #e9ecef; border-left: 4px solid #3498db; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; color: #2c3e50;">{{ $service->name }}</h4>
                <p style="color: #6c757d; margin: 0 0 10px 0;">{{ $service->description }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 4px; font-weight: 600;">{{ number_format($service->pivot->subtotal, 2) }}</span>
                    @if($service->timeline_weeks)
                    <span style="background: #fff3e0; color: #f57c00; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $service->timeline_weeks }} weeks</span>
                    @endif
                    <span>Quantity: {{ $service->pivot->quantity }}</span>
                </div>
            </div>
            @endforeach

            <!-- Pricing -->
            <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 8px;">Investment Summary</h3>
            <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; padding: 30px; text-align: center; margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 16px;">
                    <span>Subtotal:</span>
                    <span>{{ number_format($quotation->total_cost, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 16px;">
                    <span>GST (18%):</span>
                    <span>{{ number_format($quotation->gst_amount, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 15px; border-top: 2px solid #3498db; margin-top: 15px;">
                    <span style="font-size: 18px; font-weight: bold;">Total Investment:</span>
                    <span style="font-size: 24px; font-weight: 700; color: #27ae60;">{{ number_format($quotation->final_amount, 2) }}</span>
                </div>
            </div>

            <!-- Executive Summary -->
            @if($quotation->executive_summary)
            <h3 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 8px;">Executive Summary</h3>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                <p>{{ $quotation->executive_summary }}</p>
            </div>
            @endif

            <!-- Approval Section -->
            <div style="text-align: center; margin: 40px 0; padding: 30px; background: #f8f9fa; border-radius: 12px; border: 2px dashed #3498db;">
                <h3 style="color: #2c3e50; margin-bottom: 20px;">📋 Take Action on This Quotation</h3>
                <p style="color: #6c757d; margin-bottom: 25px;">Please review the quotation and click below to approve:</p>
                
                <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                    <a href="{{ route('quotations.approve', $approveToken) }}" style="display: inline-block; padding: 15px 30px; background: #27ae60; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(39, 174, 96, 0.2);">
                        ✅ Approve Quotation
                    </a>
                </div>
                
                <p style="color: #6c757d; font-size: 14px; margin-top: 20px; font-style: italic;">
                    Click the button above to approve this quotation. You can also contact us directly:
                </p>
                
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6;">
                    <a href="tel:+919220518202" style="display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 6px; margin: 5px; font-size: 14px;">
                        Call Us
                    </a>
                    <h4>Thank you for choosing NIRCRM!</h4>
                    <a href="mailto:udyami.nircrm24@gmail.com" style="display: inline-block; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 6px; margin: 5px; font-size: 14px;">
                        Email Us
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #2c3e50; color: white; padding: 30px; text-align: center;">
            <h4 style="margin: 0 0 15px 0; color: #3498db;">NIRCRM - Digital Solutions</h4>
            <div style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 20px; margin: 20px 0;">
                <p style="margin: 8px 0;"> Email: udyami.nircrm24@gmail.com</p>
                <p style="margin: 8px 0;"> Phone: +91-9220518202</p>
                <p style="margin: 8px 0;"> Website: www.nircrm.com</p>
            </div>
            <p>We at NIRCRM appreciate your interest and look forward to working with you.</p>
            <p style="margin: 10px 0;"><strong>Best regards,<br>{{ $quotation->creator->name }}<br>NIRCRM Team</strong></p>
        </div>
    </div>
</body>
</html>
