<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // <-- ALWAYS at the very top of any PHP file using sessions

require_once 'vendor/autoload.php';
require_once 'connect.php'; // <-- Your mysqli database connection file

// Load .env variables (assuming you have a .env file for sensitive keys)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$clientID = $_ENV['GOOGLE_CLIENT_ID'] ?? null; // Use null coalescing for safety
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? null;
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? null;

// Initialize Google_Client only if credentials are set
$client = null;
if ($clientID && $clientSecret && $redirectUri) {
    try {
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
    } catch (Exception $e) {
        error_log("Google Client initialization error: " . $e->getMessage());
        $google_auth_error = "Google login is temporarily unavailable due to configuration issues.";
    }
} else {
    $google_auth_error = "Google API credentials are not configured in your .env file.";
}

$error_message = ''; // Initialize error message for form logins

// --- Handle Google OAuth Flow ---
// This block executes when Google redirects back to your login.php with a 'code'
if (isset($_GET['code']) && $client) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        // Check if token fetch was successful
        if (isset($token['access_token'])) {
            // --- TYPO FIXED HERE: 'access_access_token' corrected to 'access_token' ---
            $client->setAccessToken($token['access_token']);

            // Get profile info from Google
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name =  $google_account_info->name; // Full name from Google

            // --- Integrate with your database for Google sign-ins ---
            // Check if this Google email already exists in your 'users' table.
            // If it does, log them in (retrieve username, fName, lName etc.).
            // If it doesn't, consider automatically registering them or prompting them to register.

            $stmt = $conn->prepare("SELECT id, firstName, lastName, email FROM users WHERE email = ?");
            if ($stmt === false) {
                 error_log("Google OAuth DB prepare failed: " . $conn->error);
                 $error_message = "Google login experienced a database error during user lookup.";
            } else {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // User exists, log them in
                    $user = $result->fetch_assoc();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['username'] = $user['firstName'] . ' ' . $user['lastName']; // Use your DB names
                } else {
                    // User does not exist, set session using Google info.
                    // In a real application, you might want to automatically
                    // register this user into your 'users' table here.
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $name; // Use Google name for initial display if not in DB
                }
                $stmt->close();
            }

            header("Location: proper.php"); // Redirect to your main dashboard
            exit();
        } else {
            error_log("Google OAuth: Failed to fetch access token from Google response. Code: " . ($_GET['code'] ?? 'N/A'));
            $error_message = "Google login failed. Could not retrieve access token.";
            header("Location: login.php?error=oauth_token_empty"); // Redirect to clean URL
            exit();
        }
    } catch (Exception $e) {
        error_log("Google OAuth process exception: " . $e->getMessage());
        $error_message = "An unexpected error occurred during Google login. Please try again.";
        header("Location: login.php?error=oauth_exception"); // Redirect to clean URL
        exit();
    }
}


// --- Handle Traditional Email/Password Sign In Form Submission (from THIS page) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signIn'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error_message = 'Please enter both email and password.';
    } else {
        // Use mysqli prepared statements for security
        // Assumes your 'users' table has 'email', 'password' (hashed), 'firstName', 'lastName'
        $stmt = $conn->prepare("SELECT id, firstName, lastName, email, password FROM users WHERE email = ?");
        if ($stmt === false) {
            error_log("Traditional login prepare failed: " . $conn->error);
            $error_message = "Internal server error. Please try again later.";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                // Verify the hashed password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, set session variables
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $user['firstName'] . ' ' . $user['lastName']; // Use names from your DB
                    $_SESSION['email'] = $user['email'];

                    $stmt->close();
                    // Close connection here if no more DB operations are needed after login redirect
                    // $conn->close();
                    header('Location: proper.php'); // Redirect to your main dashboard
                    exit();
                } else {
                    $error_message = 'Invalid email or password.'; // Password mismatch
                }
            } else {
                $error_message = 'Invalid email or password.'; // No user found with that email
            }
            $stmt->close();
        }
    }
}

// Keep the database connection open until rendering, then close if not closed above
// Or handle closing at script end via __destruct if using a custom DB class
if ($conn && $conn->ping()) { // Check if connection is still open before trying to close
    // $conn->close(); // Optional: Close connection here if sure it's not needed by included scripts or later processing
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>VarApps Login/Register</title>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red; text-align: center; margin-top: 20px;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <?php if (isset($google_auth_error) && $google_auth_error): ?>
        <p style="color: orange; text-align: center; margin-top: 20px;"><?php echo htmlspecialchars($google_auth_error); ?></p>
    <?php endif; ?>

    <div class="container" id="signup" style="display:none;">
        <h1 class="form-title">Welcome to VarApps</h1>
            <form method="post" action="register.php"> <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fName" id="fName_reg" placeholder="First Name" required>
                    <label for="fName_reg">First Name</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lName" id="lName_reg" placeholder="Last Name" required>
                    <label for="lName_reg">Last Name</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email_reg" placeholder="Email" required>
                    <label for="email_reg">Email</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password_reg" placeholder="Password" required>
                    <label for="password_reg">Password</label>
                </div>
                <input type="submit" value="Sign Up" name="signUp" class="btn">
            </form>
            <p class="or">
                ---------- OR ----------
            </p>
            <div class="icons">
                <?php if ($client): ?>
                    <a href="<?php echo htmlspecialchars($client->createAuthUrl()); ?>"> <i class="fab fa-google"></i> </a>
                <?php else: ?>
                    <span style="color:#aaa; cursor:not-allowed;" title="Google login not configured or client failed to initialize"><i class="fab fa-google"></i></span>
                <?php endif; ?>
            </div>
            <div class="links">
                <p>Already have an account?</p>
                <button id="signInButton">Sign In</button>
            </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Welcome to VarApps</h1>
            <form method="post" action="login.php"> <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email_login" placeholder="Email" required>
                    <label for="email_login">Email</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password_login" placeholder="Password" required>
                    <label for="password_login">Password</label>
                </div>
                <p class="recover">
                    <a href="forgot_password.php">Forgot Password?</a>
                </p>
                <input type="submit" value="Sign In" name="signIn" class="btn">
            </form>
            <p class="or">
                ---------- OR ----------
            </p>
            <div class="icons">
                <?php if ($client): ?>
                    <a href="<?php echo htmlspecialchars($client->createAuthUrl()); ?>"><i class="fab fa-google"></i></a>
                <?php else: ?>
                    <span style="color:#aaa; cursor:not-allowed;" title="Google login not configured or client failed to initialize"><i class="fab fa-google"></i></span>
                <?php endif; ?>
            </div>
            <div class="links">
                <p>Don't have an account yet?</p>
                <button id="signUpButton">Sign Up</button>
            </div>
    </div>
    <script src="script.js"></script>
    <script src="theme.js"></script>
</body>
</html>