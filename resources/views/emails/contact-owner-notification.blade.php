<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Property Inquiry</title>
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
            background-color: #251605;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .property-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .client-info {
            background-color: #e8f4f8;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin: 20px 0;
        }
        .message-box {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #251605;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 5px;
        }
        .button:hover {
            background-color: #3a2408;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .property-details {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .property-details span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏠 New Property Inquiry</h1>
        <p>You have received a new message about your property</p>
    </div>

    <div class="content">
        <h2>Hello {{ $property->owner->name }},</h2>
        
        <p>You have received a new inquiry about your property listing. A potential client is interested and would like to get in touch with you.</p>

        <!-- Property Information -->
        <div class="property-card">
            <h3>📍 Property Details</h3>
            <div class="property-details">
                <strong>{{ $property->title }}</strong>
            </div>
            <div class="property-details">
                <span>Location:</span>
                <span>{{ $property->address }}, {{ $property->city->name }}</span>
            </div>
            <div class="property-details">
                <span>Price:</span>
                <span>{{ $property->formatted_price }}</span>
            </div>
            <div class="property-details">
                <span>Category:</span>
                <span>{{ $property->category->name }}</span>
            </div>
            <div class="property-details">
                <span>Size:</span>
                <span>{{ $property->bedrooms }} beds, {{ $property->bathrooms }} baths, {{ number_format($property->area) }} m²</span>
            </div>
        </div>

        <!-- Client Information -->
        <div class="client-info">
            <h3>👤 Client Information</h3>
            <p><strong>Name:</strong> {{ $contact->client_name }}</p>
            <p><strong>Email:</strong> {{ $contact->client_email }}</p>
            @if($contact->client_phone)
                <p><strong>Phone:</strong> {{ $contact->client_phone }}</p>
            @endif
            <p><strong>Inquiry Date:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <!-- Client Message -->
        <div class="message-box">
            <h3>💬 Client Message</h3>
            <p style="font-style: italic; background-color: #f8f9fa; padding: 15px; border-radius: 6px;">
                "{{ $contact->message }}"
            </p>
        </div>

        <!-- Action Buttons -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="mailto:{{ $contact->client_email }}?subject=Re: Property Inquiry - {{ $property->title }}&body=Hello {{ $contact->client_name }},%0D%0A%0D%0AThank you for your interest in my property: {{ $property->title }}.%0D%0A%0D%0A" 
               class="button">
                📧 Reply to Client
            </a>
            
            <a href="{{ route('properties.show', $property) }}" class="button">
                🏠 View Property
            </a>
        </div>

        <!-- Next Steps -->
        <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 20px; margin: 20px 0;">
            <h3 style="color: #856404;">📋 Next Steps</h3>
            <ol style="color: #856404;">
                <li><strong>Respond to the client</strong> - Reply to their email or call them directly</li>
                <li><strong>Schedule a viewing</strong> - The client may request to schedule a property visit</li>
                <li><strong>Answer questions</strong> - Provide any additional information they need</li>
                <li><strong>Negotiate terms</strong> - Discuss price, availability, and conditions</li>
            </ol>
        </div>

        <!-- Contact Tips -->
        <div style="background-color: #d1ecf1; border: 1px solid #bee5eb; border-radius: 8px; padding: 20px; margin: 20px 0;">
            <h3 style="color: #0c5460;">💡 Response Tips</h3>
            <ul style="color: #0c5460;">
                <li>Respond promptly to show professionalism</li>
                <li>Provide clear and detailed answers</li>
                <li>Be flexible with viewing schedules</li>
                <li>Highlight unique features of your property</li>
                <li>Be transparent about terms and conditions</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent from your Real Estate Platform</p>
        <p>If you have any questions, please contact our support team.</p>
        <p style="margin-top: 20px;">
            <a href="{{ route('home') }}" style="color: #251605;">Visit Our Website</a> | 
            <a href="mailto:support@realestate.com" style="color: #251605;">Contact Support</a>
        </p>
    </div>
</body>
</html>
