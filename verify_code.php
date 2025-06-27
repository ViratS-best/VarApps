<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_code = trim($_POST['code']);
    if ($input_code == $_SESSION['reset_code']) {
        header("Location: reset_password.php?token=" . $_SESSION['reset_token']);
        exit();
    } else {
        $error = "Incorrect code!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Code</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="form-title">Enter Verification Code</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <div class="input-group">
            <i class="fas fa-key"></i>
            <input type="text" name="code" required placeholder="6-digit code">
            <label for="code">Verification Code</label>
        </div>
        <input type="submit" class="btn" value="Verify">
    </form>
</div>
</body>
</html>