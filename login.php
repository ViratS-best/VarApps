<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Register & Login</title>
</head>
<body>
    <div class="container" id="signup" style="display:none;">
        <h1 class="form-title">Welcome to VarCart</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fName" id="fName" placeholder="First Name" required>
                    <label for="fName">First Name</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                    <label for="lName">Last Name</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <input type="submit" value="Sign Up" name="signUp" class="btn">
            </form>
            <p class="or">
                ---------- OR ----------
            </p>
            <?php
require_once 'vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$clientID = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'];

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  // Start session and store user info
  session_start();
  $_SESSION['email'] = $email;
  $_SESSION['name'] = $name;

  // Redirect to Dashboard
  header("Location: Dashboard.php");
  exit();
?>
// now you can use this profile info to create account in your website and make user logged in.
<?php } else {?>
            <div class="icons">
                <a href="<?php echo $client->createAuthUrl() ?>"> <i class="fab fa-google"></i> </a>
                <!-- <i class="fab fa-facebook-f"></i> -->
            </div>
            <div class="links">
                <p>Already have an account?</p>
                <button id="signInButton">Sign In</button>
            </div>
            </div>
<?php } ?>


            <div class="container" id="signIn">
        <h1 class="form-title">Welcome to VarCart</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
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
                <a href="<?php echo $client->createAuthUrl() ?>"><i class="fab fa-google"></i></a>
                <!-- <i class="fab fa-facebook-f"></i> -->
            </div>
            <div class="links">
                <p>Don't have a account yet?</p>
                <button id="signUpButton">Sign Up</button>
            </div>
            </div>
    <script src="script.js"></script>
    <script src="theme.js"></script>
</body>
</html>