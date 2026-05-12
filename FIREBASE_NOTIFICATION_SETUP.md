# Firebase Notification Setup Guide

## Overview
This guide will help you set up Firebase Cloud Messaging (FCM) notifications for new call recordings.

## Step 1: Get Firebase Server Key

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project (or create a new one)
3. Go to Project Settings (⚙️ icon)
4. Click on "Cloud Messaging" tab
5. Copy the "Server key" (it starts with "AAAA...")

## Step 2: Add Server Key to Environment

Add this line to your `.env` file:

```env
FIREBASE_SERVER_KEY=AAAA..._YOUR_ACTUAL_SERVER_KEY_HERE
```

**Important**: Replace `AAAA..._YOUR_ACTUAL_SERVER_KEY_HERE` with your actual Firebase Server Key.

## Step 3: Configure Firebase Topic

Make sure your mobile app is subscribed to the `all_users` topic:

### Flutter Example:
```dart
// Subscribe to topic
FirebaseMessaging.instance.subscribeToTopic('all_users');

// Handle notifications
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  print('Received notification: ${message.notification?.title}');
});
```

### Android Example (Kotlin):
```kotlin
// Subscribe to topic
Firebase.messaging.subscribeToTopic("all_users")
    .addOnCompleteListener { task ->
        if (task.isSuccessful) {
            Log.d(TAG, "Subscribed to all_users topic")
        }
    }
```

## Step 4: Test the Setup

1. Upload a new recording through your mobile app
2. Check if notification is sent to all subscribed devices
3. Check Laravel logs: `storage/logs/laravel.log`

## Notification Content

When a new recording is uploaded, the system will send:

- **Title**: "New Recording"
- **Message**: "A new call from [Customer Name] ([Phone Number]) was recorded"
- **Target URL**: `https://yourdomain.com/allrecordingcall`
- **Priority**: High

## Troubleshooting

### No notifications received?
1. Check `.env` file has correct `FIREBASE_SERVER_KEY`
2. Verify mobile app is subscribed to `all_users` topic
3. Check Laravel logs for errors
4. Ensure FCM is enabled in Firebase project settings

### Server Key Issues
- Never expose your Server Key in frontend code
- Keep it secure in environment variables
- Regenerate if compromised

## Security Notes

- The Server Key is sensitive information
- Never commit it to version control
- Use different keys for development and production
- Monitor usage in Firebase Console

## Features

✅ **Automatic notifications** sent when new recordings are uploaded
✅ **High priority** delivery for immediate attention
✅ **Custom messages** with customer details
✅ **Direct links** to recordings page
✅ **Error handling** with detailed logging
✅ **Environment-based configuration** for security

## How It Works

1. Mobile app uploads recording to `/api/sync-recording`
2. Recording is saved to database successfully
3. Firebase notification is automatically sent to all users
4. Users receive notification with recording details
5. Clicking notification opens recordings page

The system is now ready to send real-time notifications for all new call recordings!
