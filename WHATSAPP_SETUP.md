# WhatsApp API Integration Setup Guide

## Overview
This guide will help you set up the WhatsApp API integration for your NIRCRM system.

## Prerequisites
1. WhatsApp Business Account
2. Facebook Developer Account
3. Meta Business Suite Account
4. Verified Business (if required for your region)

## Step 1: Create WhatsApp Business App

1. Go to [Meta for Developers](https://developers.facebook.com/)
2. Create a new app
3. Select "Business" as the app type
4. Add "WhatsApp" product to your app
5. Complete the setup process

## Step 2: Get API Credentials

You will need the following credentials:
- **Access Token**: From your WhatsApp app settings
- **Phone Number ID**: From your WhatsApp business number
- **Webhook Verify Token**: Custom token for webhook verification
- **API URL**: Usually `https://graph.facebook.com/v15.0`

## Step 3: Configure Environment Variables

Add the following to your `.env` file:

```env
# WhatsApp API Configuration
WHATSAPP_API_URL=https://graph.facebook.com/v15.0
WHATSAPP_ACCESS_TOKEN=your_access_token_here
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id_here
WHATSAPP_WEBHOOK_VERIFY_TOKEN=your_custom_webhook_token
WHATSAPP_WEBHOOK_URL=https://your-domain.com/whatsapp/webhook

# Rate Limiting (optional)
WHATSAPP_RATE_LIMIT=1
WHATSAPP_RATE_LIMIT_MINUTE=30
WHATSAPP_RATE_LIMIT_HOUR=1000
WHATSAPP_RATE_LIMIT_DAY=10000
```

## Step 4: Test the Integration

1. Navigate to `/whatsapp` in your CRM
2. Click "Check Status" to verify API connection
3. Send a test message to verify functionality

## Features

### 1. WhatsApp Dashboard (`/whatsapp`)
- View all leads with phone numbers
- Send individual messages
- Send bulk messages
- Use message templates
- Check API status

### 2. Leads Management Integration (`/leadsmanagement`)
- WhatsApp button added to each lead's actions
- Quick message sending directly from leads list
- Pre-filled recipient information

### 3. Message Templates
- Follow-up messages
- Quotation notifications
- Appointment reminders
- Service announcements
- Welcome messages
- Thank you messages

## API Endpoints

### GET `/whatsapp`
Display WhatsApp management dashboard

### POST `/whatsapp/send`
Send individual message
```json
{
    "lead_id": 1,
    "message": "Your message here",
    "message_type": "text"
}
```

### POST `/whatsapp/bulk-send`
Send bulk messages
```json
{
    "lead_ids": [1, 2, 3],
    "message": "Your bulk message here",
    "message_type": "text"
}
```

### GET `/whatsapp/templates`
Get available message templates

### GET `/whatsapp/status`
Check WhatsApp API connection status

## Webhook Setup (Optional)

If you want to receive incoming messages:

1. Set up webhook URL in your WhatsApp app settings
2. Add webhook routes to handle incoming messages
3. Configure webhook events in `config/whatsapp.php`

## Rate Limiting

The system includes built-in rate limiting to prevent API abuse:
- 1 message per second (default)
- 30 messages per minute
- 1000 messages per hour
- 10000 messages per day

## Security Considerations

1. Never commit your access token to version control
2. Use HTTPS for all webhook URLs
3. Validate incoming webhook requests
4. Implement proper authentication for your webhook endpoints

## Troubleshooting

### Common Issues

1. **"WhatsApp API credentials not configured"**
   - Check your `.env` file
   - Ensure all required variables are set

2. **"Failed to connect to WhatsApp API"**
   - Verify your access token is valid
   - Check your phone number ID
   - Ensure API URL is correct

3. **"Message not sent"**
   - Check phone number format (include country code)
   - Verify recipient has WhatsApp
   - Check rate limiting

### Debug Mode

Add this to your `.env` for debugging:
```env
LOG_LEVEL=debug
```

## Support

For WhatsApp API issues:
- [Meta for Developers Documentation](https://developers.facebook.com/docs/whatsapp/)
- [WhatsApp Business API Support](https://developers.facebook.com/docs/whatsapp/support/)

For CRM integration issues:
- Check the logs in `storage/logs/laravel.log`
- Verify all routes are properly configured
- Ensure database migrations are run

## Best Practices

1. **Message Personalization**: Use templates with variables for personalized messages
2. **Timing**: Send messages during business hours
3. **Compliance**: Follow WhatsApp's Business Messaging Policies
4. **Opt-out**: Always provide an option for users to opt-out
5. **Testing**: Test thoroughly before sending to real customers

## Future Enhancements

- Message history tracking
- Automated follow-up sequences
- Campaign management
- Analytics and reporting
- Two-way messaging support
- Media file sharing
- Interactive buttons and lists
