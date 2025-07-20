<?php
// spotify_callback.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Crucial to access and store session variables

// --- LOAD ENVIRONMENT VARIABLES ---
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('SPOTIFY_CLIENT_ID', $_ENV['SPOTIFY_CLIENT_ID']);
define('SPOTIFY_CLIENT_SECRET', $_ENV['SPOTIFY_CLIENT_SECRET']);
define('SPOTIFY_REDIRECT_URI', $_ENV['SPOTIFY_REDIRECT_URI']);

// Verify the 'state' parameter to prevent CSRF
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['spotify_auth_state']) {
    // State mismatch, possible CSRF attack
    header('Location: varmusic.php?error=state_mismatch');
    exit();
}

// Check if an error was returned from Spotify
if (isset($_GET['error'])) {
    header('Location: varmusic.php?error=' . urlencode($_GET['error']));
    exit();
}

// Get the authorization code
if (!isset($_GET['code'])) {
    header('Location: varmusic.php?error=no_code_received');
    exit();
}
$authCode = $_GET['code'];

// Exchange the authorization code for an access token and refresh token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token'); // Spotify token endpoint
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'code'       => $authCode,
    'redirect_uri' => SPOTIFY_REDIRECT_URI,
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Basic ' . base64_encode(SPOTIFY_CLIENT_ID . ':' . SPOTIFY_CLIENT_SECRET),
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if (curl_errno($ch)) {
    header('Location: varmusic.php?error=curl_error&details=' . urlencode(curl_error($ch)));
    exit();
}

$data = json_decode($response, true);

// Check for errors in the token exchange
if ($httpCode !== 200 || !isset($data['access_token'])) {
    $errorMsg = $data['error_description'] ?? ($data['error'] ?? 'Unknown token exchange error.');
    header('Location: varmusic.php?error=token_exchange_failed&details=' . urlencode($errorMsg));
    exit();
}

// Store tokens and potentially user info in session
$_SESSION['spotify_access_token'] = $data['access_token'];
$_SESSION['spotify_refresh_token'] = $data['refresh_token'];
$_SESSION['spotify_token_expires_in'] = time() + $data['expires_in']; // Time when token expires

// Optionally, fetch user's profile to display their name
$chUser = curl_init();
curl_setopt($chUser, CURLOPT_URL, 'http://googleusercontent.com/spotify.com/4'); // Spotify user profile endpoint
curl_setopt($chUser, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chUser, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $data['access_token']
]);
$userResponse = curl_exec($chUser);
$userHttpCode = curl_getinfo($chUser, CURLINFO_HTTP_CODE);
curl_close($chUser);

if ($userHttpCode === 200) {
    $userData = json_decode($userResponse, true);
    if (isset($userData['display_name'])) {
        $_SESSION['spotify_user_display_name'] = $userData['display_name'];
        $_SESSION['spotify_user_id'] = $userData['id'];
    }
}

// Redirect back to the main application page
header('Location: varmusic.php?status=loggedin');
exit();
?>