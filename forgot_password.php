<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'connect.php';
    $email = trim($_POST['email']);
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        // Generate code and expiry
        $code = rand(100000, 999999);
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Store in DB
        $stmt2 = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt2->bind_param("sss", $email, $token, $expires);
        $stmt2->execute();
        $stmt2->close();

        // Send email
        require 'vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['GMAIL_USER']; // your Gmail
        $mail->Password = $_ENV['GMAIL_PASS'];    // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('viratsuper6@gmail.com', 'VarApps');
        $mail->addAddress($email);

        $mail->Subject = 'Your Password Reset Code';
        $mail->Body    = "Your code is: $code\nOr click: http://localhost/Hotel_Manager/reset_password.php?token=$token";

        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        if(!$mail->send()) {
            $error = 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            // Store code in session for verification
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_code'] = $code;
            $_SESSION['reset_token'] = $token;

            header("Location: verify_code.php");
            exit();
        }
    } else {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="form-title">Forgot Password</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" required placeholder="Email">
            <label for="email">Email</label>
        </div>
        <input type="submit" class="btn" value="Send Code">
    </form>
</div>
<script src="theme.js"></script>
</body>
</html>