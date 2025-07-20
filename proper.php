<?php
// proper.php - The Main Dashboard

session_start(); // Start a session to manage user login status

// Check if the user is logged in.
// If not logged in, redirect them to login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit; // Always exit after a header redirect
}

// If they are logged in, display the dashboard content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VarApps Dashboard</title>
   
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
        }
        h1 {
            color: #0056b3;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 30px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px; /* Space between buttons */
            flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
        }
        .app-button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            min-width: 150px; /* Ensure buttons have a minimum width */
        }
        .app-button:hover {
            background-color: #0056b3;
        }
        .logout-button {
            margin-top: 30px;
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="container">
        <button id="theme-toggle" class="theme-toggle">🌙 Dark/Light</button>
        <h1>Welcome to Your VarApps Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Your central hub for all your daily online activities. Choose an app to get started:</p>

        <div class="button-group">
            <a href="Dashboard.php" class="app-button">Go to VarCart</a>
            <a href="varai.php" class="app-button">Launch VarAI</a>
            <a href="varmusic.php" class="app-button">Play VarMusic</a>
        </div>

        <a href="logout.php" class="logout-button">Log Out</a>
    </div>
<script src="theme.js"></script>
</body>
</html>