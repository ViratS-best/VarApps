<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

function redirect($url) {
    header("Location: $url");
    exit();
}

if (isset($_POST['signUp'])) {
    $firstName = trim($_POST['fName']);
    $lastName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already exists!'); window.location.href='login.php';</script>";
        exit();
    }
    $stmt->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_POST['signIn'])) {
    // Add this line for debugging
    error_log("Login POST received", 0);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $dbEmail, $dbPassword);
        $stmt->fetch();
        if (password_verify($password, $dbPassword)) {
            session_start();
            $_SESSION['email'] = $dbEmail;
            redirect("Dashboard.php");
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email not found!'); window.location.href='login.php';</script>";
        exit();
    }
    $stmt->close();
}
?>