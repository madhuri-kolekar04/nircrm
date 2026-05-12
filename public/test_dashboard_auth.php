<?php

// Include Laravel bootstrap
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test request to the dashboard
$request = Illuminate\Http\Request::create('/attendance/dashboard', 'GET');

// Simulate authentication by creating a user
$user = \App\Models\User::first();
if ($user) {
    \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
    \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
}

// Handle the request
$response = $kernel->handle($request);

// Output the response
echo "Status Code: " . $response->getStatusCode() . "\n";
echo "Content Type: " . $response->headers->get('Content-Type') . "\n";
echo "Content Length: " . strlen($response->getContent()) . "\n";

// Show first 2000 characters of content
$content = $response->getContent();
echo "Content Preview:\n";
echo substr($content, 0, 2000);
echo "\n";

$kernel->terminate($request, $response);
