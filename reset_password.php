<?php
include 'connect.php';
session_start();
if (!isset($_GET['token']) || !isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}
$token = $_GET['token'];
$email = $_SESSION['reset_email'];

// Check token validity
$stmt = $conn->prepare("SELECT expires_at FROM password_resets WHERE email = ? AND token = ?");
$stmt->bind_param("ss", $email, $token);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($expires_at);
if ($stmt->num_rows == 1) {
    $stmt->fetch();
    if (strtotime($expires_at) < time()) {
        $error = "Token expired!";
    }
} else {
    $error = "Invalid token!";
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
    $password = $_POST['password'];
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
    $stmt->bind_param("ss", $hashed, $email);
    if ($stmt->execute()) {
        // Clean up
        $conn->query("DELETE FROM password_resets WHERE email='$email'");
        unset($_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_token']);
        echo "<script>alert('Password reset successful!'); window.location.href='login.php';</script>";
        exit();
    } else {
        $error = "Failed to reset password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="form-title">Reset Password</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" required placeholder="New Password">
            <label for="password">New Password</label>
        </div>
        <input type="submit" class="btn" value="Reset Password">
    </form>
</div>
<script src="theme.js"></script>
</body>
</html>