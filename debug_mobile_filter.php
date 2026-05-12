<?php
// Debug script to test mobile filter functionality
// This will help identify if the issue is frontend or backend

// Include necessary files
require_once 'vendor/autoload.php';

// Set headers
header('Content-Type: application/json');

// Simulate a filter request
$filters = [
    'employee_id' => '',
    'status' => '',
    'date_from' => '',
    'date_to' => ''
];

// Check if this is a mobile request
$isMobile = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']);

echo json_encode([
    'debug_info' => [
        'is_mobile' => $isMobile,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown',
        'filters_received' => $filters
    ],
    'message' => 'Debug endpoint - check browser console for details'
]);
?>
