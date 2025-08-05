<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment {{ ucfirst($appointment->status) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #251605;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            margin: 10px 0;
        }
        .confirmed {
            background: #d1fae5;
            color: #065f46;
        }
        .rejected {
            background: #fee2e2;
            color: #991b1b;
        }
        .property-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #F7DBA7;
        }
        .appointment-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #251605;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
        .btn:hover {
            background: #3d2a0f;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            @if($appointment->status === 'confirmed')
                🎉 Appointment Confirmed!
            @else
                📅 Appointment Update
            @endif
        </h1>
    </div>

    <div class="content">
        <p>Dear {{ $appointment->client->name }},</p>

        @if($appointment->status === 'confirmed')
            <p>Great news! Your appointment request has been <strong>confirmed</strong> by the property owner.</p>
        @else
            <p>We regret to inform you that your appointment request has been <strong>{{ $appointment->status }}</strong> by the property owner.</p>
        @endif

        <div class="status-badge {{ $appointment->status }}">
            {{ ucfirst($appointment->status) }}
        </div>

        <div class="property-details">
            <h3>🏠 Property Details</h3>
            <p><strong>Property:</strong> {{ $appointment->property->title }}</p>
            <p><strong>Address:</strong> {{ $appointment->property->address }}</p>
            <p><strong>Price:</strong> ${{ number_format($appointment->property->price, 2) }} 
                @if($appointment->property->listing_type === 'rent') / month @endif
            </p>
            <p><strong>Owner:</strong> {{ $appointment->property->owner->name }}</p>
        </div>

        <div class="appointment-details">
            <h3>📅 Appointment Details</h3>
            <p><strong>Date & Time:</strong> {{ $appointment->appointment_date->format('l, F j, Y \a\t g:i A') }}</p>
            <p><strong>Requested on:</strong> {{ $appointment->created_at->format('F j, Y \a\t g:i A') }}</p>
            
            @if($appointment->client_message)
                <p><strong>Your Message:</strong></p>
                <p style="background: #f3f4f6; padding: 15px; border-radius: 6px; font-style: italic;">
                    "{{ $appointment->client_message }}"
                </p>
            @endif

            @if($appointment->owner_response)
                <p><strong>Owner's Response:</strong></p>
                <p style="background: #f3f4f6; padding: 15px; border-radius: 6px;">
                    {{ $appointment->owner_response }}
                </p>
            @endif
        </div>

        @if($appointment->status === 'confirmed')
            <div style="background: #d1fae5; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #065f46; margin-top: 0;">✅ Next Steps</h3>
                <ul style="color: #065f46;">
                    <li>Your appointment is confirmed for {{ $appointment->appointment_date->format('l, F j, Y \a\t g:i A') }}</li>
                    <li>Please arrive on time at the property address</li>
                    <li>Bring a valid ID for verification</li>
                    <li>Contact the owner if you need to reschedule</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('appointments.show', $appointment) }}" class="btn">
                    View Appointment Details
                </a>
            </div>
        @else
            <div style="background: #fee2e2; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #991b1b; margin-top: 0;">What's Next?</h3>
                <p style="color: #991b1b;">
                    Don't worry! You can browse other similar properties or try scheduling a different time.
                </p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('properties.show', $appointment->property) }}" class="btn">
                    View Property Again
                </a>
            </div>
        @endif

        <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3>📞 Need Help?</h3>
            <p>If you have any questions or need assistance, please don't hesitate to contact us:</p>
            <ul>
                <li>Email: support@realestate.com</li>
                <li>Phone: (555) 123-4567</li>
                <li>Live Chat: Available on our website</li>
            </ul>
        </div>

        <p>Thank you for using our platform!</p>
        <p>Best regards,<br>The Real Estate Team</p>
    </div>

    <div class="footer">
        <p>This email was sent regarding your appointment request on our Real Estate Platform.</p>
        <p>© {{ date('Y') }} Real Estate Platform. All rights reserved.</p>
    </div>
</body>
</html>
