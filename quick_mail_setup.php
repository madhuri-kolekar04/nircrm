<?php

// Quick Mail Setup Helper
echo "=== QUICK MAIL SETUP ===\n\n";

echo "This script will help you quickly set up mail for testing.\n\n";

echo "Choose setup option:\n";
echo "1. Log driver (emails logged to file - FASTEST FOR TESTING)\n";
echo "2. Gmail SMTP (real emails)\n";
echo "3. Mailtrap (development testing)\n";
echo "4. Check current configuration\n\n";

echo "Enter choice (1-4): ";
$choice = trim(fgets(STDIN));

switch ($choice) {
    case '1':
        setupLogDriver();
        break;
    case '2':
        setupGmail();
        break;
    case '3':
        setupMailtrap();
        break;
    case '4':
        checkCurrentConfig();
        break;
    default:
        echo "Invalid choice. Running configuration check...\n";
        checkCurrentConfig();
}

function setupLogDriver() {
    echo "\n=== SETTING UP LOG DRIVER ===\n";
    
    $envFile = __DIR__ . '/.env';
    $envContent = file_exists($envFile) ? file_get_contents($envFile) : '';
    
    // Mail configuration for log driver
    $mailConfig = [
        'MAIL_MAILER=log',
        'MAIL_FROM_ADDRESS=test@example.com',
        'MAIL_FROM_NAME="Test Company"'
    ];
    
    // Update or add mail settings
    $lines = explode("\n", $envContent);
    $newLines = [];
    
    foreach ($lines as $line) {
        $shouldReplace = false;
        foreach ($mailConfig as $config) {
            $key = explode('=', $config)[0];
            if (strpos($line, $key . '=') === 0) {
                $newLines[] = $config;
                $shouldReplace = true;
                break;
            }
        }
        if (!$shouldReplace) {
            $newLines[] = $line;
        }
    }
    
    // Add missing configs
    foreach ($mailConfig as $config) {
        $key = explode('=', $config)[0];
        $found = false;
        foreach ($newLines as $line) {
            if (strpos($line, $key . '=') === 0) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $newLines[] = $config;
        }
    }
    
    file_put_contents($envFile, implode("\n", $newLines));
    
    echo "✅ Log driver configured!\n";
    echo "📧 Emails will now be logged to: storage/logs/laravel.log\n";
    echo "🚀 Run: php artisan config:clear\n";
    echo "🧪 Test by clicking mail icon on sales department page\n";
}

function setupGmail() {
    echo "\n=== GMAIL SMTP SETUP ===\n";
    echo "⚠️  IMPORTANT: You need a Gmail App Password, not your regular password!\n";
    echo "📝 Steps:\n";
    echo "   1. Enable 2-factor authentication on Gmail\n";
    echo "   2. Go to Google Account -> Security -> App Passwords\n";
    echo "   3. Generate new app password\n";
    echo "   4. Use that password below (not your Gmail password)\n\n";
    
    echo "Enter your Gmail address: ";
    $email = trim(fgets(STDIN));
    
    echo "Enter your Gmail App Password: ";
    $password = trim(fgets(STDIN));
    
    if (empty($email) || empty($password)) {
        echo "❌ Email and password required!\n";
        return;
    }
    
    $envFile = __DIR__ . '/.env';
    $envContent = file_exists($envFile) ? file_get_contents($envFile) : '';
    
    $mailConfig = [
        'MAIL_MAILER=smtp',
        'MAIL_HOST=smtp.gmail.com',
        'MAIL_PORT=587',
        'MAIL_USERNAME=' . $email,
        'MAIL_PASSWORD=' . $password,
        'MAIL_ENCRYPTION=tls',
        'MAIL_FROM_ADDRESS=' . $email,
        'MAIL_FROM_NAME="' . explode('@', $email)[0] . '"'
    ];
    
    // Update .env file
    $lines = explode("\n", $envContent);
    $newLines = [];
    
    foreach ($lines as $line) {
        $shouldReplace = false;
        foreach ($mailConfig as $config) {
            $key = explode('=', $config)[0];
            if (strpos($line, $key . '=') === 0) {
                $newLines[] = $config;
                $shouldReplace = true;
                break;
            }
        }
        if (!$shouldReplace) {
            $newLines[] = $line;
        }
    }
    
    // Add missing configs
    foreach ($mailConfig as $config) {
        $key = explode('=', $config)[0];
        $found = false;
        foreach ($newLines as $line) {
            if (strpos($line, $key . '=') === 0) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $newLines[] = $config;
        }
    }
    
    file_put_contents($envFile, implode("\n", $newLines));
    
    echo "✅ Gmail SMTP configured!\n";
    echo "🚀 Run: php artisan config:clear\n";
    echo "🧪 Test by clicking mail icon on sales department page\n";
}

function setupMailtrap() {
    echo "\n=== MAILTRAP SETUP ===\n";
    echo "📝 Get your credentials from: https://mailtrap.io\n";
    echo "Enter your Mailtrap username: ";
    $username = trim(fgets(STDIN));
    
    echo "Enter your Mailtrap password: ";
    $password = trim(fgets(STDIN));
    
    if (empty($username) || empty($password)) {
        echo "❌ Username and password required!\n";
        return;
    }
    
    $envFile = __DIR__ . '/.env';
    $envContent = file_exists($envFile) ? file_get_contents($envFile) : '';
    
    $mailConfig = [
        'MAIL_MAILER=smtp',
        'MAIL_HOST=smtp.mailtrap.io',
        'MAIL_PORT=2525',
        'MAIL_USERNAME=' . $username,
        'MAIL_PASSWORD=' . $password,
        'MAIL_ENCRYPTION=tls',
        'MAIL_FROM_ADDRESS=test@example.com',
        'MAIL_FROM_NAME="Test Company"'
    ];
    
    // Update .env file (same logic as above)
    $lines = explode("\n", $envContent);
    $newLines = [];
    
    foreach ($lines as $line) {
        $shouldReplace = false;
        foreach ($mailConfig as $config) {
            $key = explode('=', $config)[0];
            if (strpos($line, $key . '=') === 0) {
                $newLines[] = $config;
                $shouldReplace = true;
                break;
            }
        }
        if (!$shouldReplace) {
            $newLines[] = $line;
        }
    }
    
    foreach ($mailConfig as $config) {
        $key = explode('=', $config)[0];
        $found = false;
        foreach ($newLines as $line) {
            if (strpos($line, $key . '=') === 0) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $newLines[] = $config;
        }
    }
    
    file_put_contents($envFile, implode("\n", $newLines));
    
    echo "✅ Mailtrap configured!\n";
    echo "🚀 Run: php artisan config:clear\n";
    echo "🧪 Test by clicking mail icon on sales department page\n";
}

function checkCurrentConfig() {
    echo "\n=== CURRENT CONFIGURATION ===\n";
    
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    $config = [
        'MAIL_MAILER' => env('MAIL_MAILER', 'not set'),
        'MAIL_HOST' => env('MAIL_HOST', 'not set'),
        'MAIL_PORT' => env('MAIL_PORT', 'not set'),
        'MAIL_USERNAME' => env('MAIL_USERNAME', 'not set'),
        'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'not set'),
    ];
    
    foreach ($config as $key => $value) {
        $display = $value;
        if (strpos($key, 'USERNAME') !== false && $value !== 'not set') {
            $display = '[SET]';
        }
        echo sprintf("%-20s: %s\n", $key, $display);
    }
    
    echo "\n📧 Ready to test? Run: php artisan config:clear\n";
}

echo "\n=== DONE ===\n";
