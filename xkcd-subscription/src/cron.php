<?php
// src/cron.php
require_once 'functions.php';

// Set timezone
date_default_timezone_set('UTC');

// Log execution
file_put_contents(__DIR__ . '/cron.log', '[' . date('Y-m-d H:i:s') . '] CRON job started' . PHP_EOL, FILE_APPEND);

try {
    sendXKCDUpdatesToSubscribers();
    file_put_contents(__DIR__ . '/cron.log', '[' . date('Y-m-d H:i:s') . '] Comics sent successfully' . PHP_EOL, FILE_APPEND);
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/cron.log', '[' . date('Y-m-d H:i:s') . '] Error: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
}
?>