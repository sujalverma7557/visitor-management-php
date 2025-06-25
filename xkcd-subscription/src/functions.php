<?php
// src/functions.php

function generateVerificationCode() {
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    
    if (!in_array($email, $emails)) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
        return true;
    }
    return false;
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    
    if (($key = array_search($email, $emails)) !== false) {
        unset($emails[$key]);
        file_put_contents($file, implode(PHP_EOL, $emails) . PHP_EOL);
        return true;
    }
    return false;
}

function sendVerificationEmail($email, $code, $type = 'verify') {
    $subject = '';
    $body = '';
    
    if ($type === 'verify') {
        $subject = 'Your Verification Code';
        $body = "<p>Your verification code is: <strong>$code</strong></p>";
    } elseif ($type === 'unsubscribe') {
        $subject = 'Confirm Un-subscription';
        $body = "<p>To confirm un-subscription, use this code: <strong>$code</strong></p>";
    }
    
    $headers = "From: no-reply@example.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    error_log("VERIFICATION CODE FOR $email: $code");
    return mail($email, $subject, $body, $headers);
}

function verifyCode($storedCode, $inputCode) {
    return $storedCode === $inputCode;
}

function fetchRandomXKCDComic() {
    // Get total number of comics (latest comic number)
    $latest = json_decode(file_get_contents('https://xkcd.com/info.0.json'), true);
    $latestNum = $latest['num'];
    
    // Generate random comic ID between 1 and latest
    $randomNum = mt_rand(1, $latestNum);
    
    // Fetch random comic data
    $comicData = json_decode(file_get_contents("https://xkcd.com/$randomNum/info.0.json"), true);
    
    return $comicData;
}

function fetchAndFormatXKCDData() {
    $comic = fetchRandomXKCDComic();
    
    $html = "<h2>{$comic['title']}</h2>";
    $html .= "<img src=\"{$comic['img']}\" alt=\"{$comic['alt']}\">";
    $html .= "<p>{$comic['alt']}</p>";
    
    return $html;
}

function sendXKCDUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return;
    
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $comicHtml = fetchAndFormatXKCDData();
    
    foreach ($emails as $email) {
        $unsubscribeLink = "http://yourdomain.com/unsubscribe.php?email=" . urlencode($email);
        $emailContent = "<h2>Your Daily XKCD Comic</h2>";
        $emailContent .= $comicHtml;
        $emailContent .= "<p><a href=\"$unsubscribeLink\" id=\"unsubscribe-button\">Unsubscribe</a></p>";
        
        $headers = "From: no-reply@example.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        mail($email, 'Your XKCD Comic', $emailContent, $headers);
    }
}
?>