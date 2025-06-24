<?php
session_destroy(); // Destroy the session
header("Location: login.php"); // Redirect to the login page
?>