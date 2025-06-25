<?php
// src/index.php
require_once 'functions.php';

session_start();

$error = '';
$success = '';
$showVerification = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        // Email submission
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $code = generateVerificationCode();
            $_SESSION['verification_code'] = $code;
            $_SESSION['verification_email'] = $email;
            
            if (sendVerificationEmail($email, $code)) {
                $showVerification = true;
                $success = 'Verification code sent to your email.';
            } else {
                $error = 'Failed to send verification email.';
            }
        } else {
            $error = 'Please enter a valid email address.';
        }
    } elseif (isset($_POST['verification_code'])) {
        // Verification code submission
        $inputCode = $_POST['verification_code'];
        $email = $_SESSION['verification_email'];
        $storedCode = $_SESSION['verification_code'];
        
        if (verifyCode($storedCode, $inputCode)) {
            if (registerEmail($email)) {
                $success = 'Email successfully verified and registered!';
                unset($_SESSION['verification_code']);
                unset($_SESSION['verification_email']);
            } else {
                $error = 'Email already registered.';
            }
        } else {
            $error = 'Invalid verification code.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>XKCD Comic Subscription</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input { padding: 8px; width: 100%; box-sizing: border-box; }
        button { padding: 10px 15px; background: #0066cc; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Subscribe to XKCD Comics</h1>
    
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>
        <button id="submit-email">Submit</button>
    </form>
    
    <?php if ($showVerification): ?>
    <form method="post">
        <div class="form-group">
            <label for="verification_code">Verification Code:</label>
            <input type="text" name="verification_code" maxlength="6" required>
        </div>
        <button id="submit-verification">Verify</button>
    </form>
    <?php endif; ?>
</body>
</html>