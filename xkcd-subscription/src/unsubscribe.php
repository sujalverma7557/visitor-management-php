<?php
// src/unsubscribe.php
require_once 'functions.php';

session_start();

$error = '';
$success = '';
$showVerification = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe_email'])) {
        // Email submission for unsubscribe
        $email = filter_input(INPUT_POST, 'unsubscribe_email', FILTER_SANITIZE_EMAIL);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $code = generateVerificationCode();
            $_SESSION['unsubscribe_code'] = $code;
            $_SESSION['unsubscribe_email'] = $email;
            
            if (sendVerificationEmail($email, $code, 'unsubscribe')) {
                $showVerification = true;
                $success = 'Unsubscribe verification code sent to your email.';
            } else {
                $error = 'Failed to send verification email.';
            }
        } else {
            $error = 'Please enter a valid email address.';
        }
    } elseif (isset($_POST['verification_code'])) {
        // Verification code submission for unsubscribe
        $inputCode = $_POST['verification_code'];
        $email = $_SESSION['unsubscribe_email'];
        $storedCode = $_SESSION['unsubscribe_code'];
        
        if (verifyCode($storedCode, $inputCode)) {
            if (unsubscribeEmail($email)) {
                $success = 'You have been successfully unsubscribed.';
                unset($_SESSION['unsubscribe_code']);
                unset($_SESSION['unsubscribe_email']);
            } else {
                $error = 'Email not found in our subscriptions.';
            }
        } else {
            $error = 'Invalid verification code.';
        }
    }
}

// Handle unsubscribe link from email
if (isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    $_SESSION['unsubscribe_email'] = $email;
    $showVerification = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unsubscribe from XKCD Comics</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input { padding: 8px; width: 100%; box-sizing: border-box; }
        button { padding: 10px 15px; background: #cc0000; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Unsubscribe from XKCD Comics</h1>
    
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    
    <?php if (!$showVerification): ?>
    <form method="post">
        <div class="form-group">
            <label for="unsubscribe_email">Email:</label>
            <input type="email" name="unsubscribe_email" required>
        </div>
        <button id="submit-unsubscribe">Unsubscribe</button>
    </form>
    <?php endif; ?>
    
    <?php if ($showVerification): ?>
    <form method="post">
        <div class="form-group">
            <label for="verification_code">Verification Code:</label>
            <input type="text" name="verification_code" maxlength="6" required>
        </div>
        <button id="submit-verification">Verify Unsubscription</button>
    </form>
    <?php endif; ?>
</body>
</html>