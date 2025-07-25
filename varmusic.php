<?php
// varmusic.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start a PHP session at the very beginning
// This is crucial for storing user-specific tokens
session_start();

// --- LOAD ENVIRONMENT VARIABLES ---
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// --- Spotify API Credentials (Now loaded from .env) ---
define('SPOTIFY_CLIENT_ID', $_ENV['SPOTIFY_CLIENT_ID']);
define('SPOTIFY_CLIENT_SECRET', $_ENV['SPOTIFY_CLIENT_SECRET']);
define('SPOTIFY_REDIRECT_URI', $_ENV['SPOTIFY_REDIRECT_URI']); // Your Spotify App's Redirect URI

// Define the required scopes for full playback (streaming) and user data
// 'streaming' is essential for Web Playback SDK
// 'user-read-email' & 'user-read-private' for basic user info
// 'user-read-playback-state', 'user-modify-playback-state' for playback control
// 'user-library-read', 'user-library-modify' if you want to save/unsave tracks
define('SPOTIFY_SCOPES', 'user-read-email user-read-private user-read-playback-state user-modify-playback-state streaming user-library-read user-library-modify');

// --- PHP Backend Logic for Authorization Code Flow (Initiation) ---
// This part handles the "Login with Spotify" button click
if (isset($_GET['action']) && $_GET['action'] === 'login') {
    // Generate a random state string to prevent CSRF attacks
    $state = bin2hex(random_bytes(16));
    $_SESSION['spotify_auth_state'] = $state; // Store state in session for verification later

    // Build the Spotify authorization URL
    $authUrl = 'https://accounts.spotify.com/api/token' .
               '?response_type=code' .
               '&client_id=' . urlencode(SPOTIFY_CLIENT_ID) .
               '&scope=' . urlencode(SPOTIFY_SCOPES) .
               '&redirect_uri=' . urlencode(SPOTIFY_REDIRECT_URI) .
               '&state=' . urlencode($state);

    header('Location: ' . $authUrl); // Redirect user to Spotify for authorization
    exit();
}

// --- PHP Backend Logic for Client Credentials Flow (Existing Search Functionality) ---
// This part remains the same to support general search without user login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    ob_clean();
    header('Content-Type: application/json');

    $searchQuery = trim($_POST['query']);
    $searchType = $_POST['type'] ?? 'track,artist,album';

    if (empty($searchQuery)) {
        echo json_encode(['error' => 'Search query cannot be empty.']);
        exit();
    }

    try {
        $token = getSpotifyAccessToken(); // This uses Client Credentials for public search

        if (isset($token['error'])) {
            echo json_encode(['error' => 'Failed to get Spotify access token: ' . $token['error']]);
            exit();
        }

        $accessToken = $token['access_token'];

        $spotifyResults = spotifySearch($searchQuery, $searchType, $accessToken);

        if (isset($spotifyResults['error'])) {
            echo json_encode(['error' => 'Spotify API Search Error: ' . $spotifyResults['error']]);
            exit();
        }

        echo json_encode(['success' => true, 'results' => $spotifyResults]);
        exit();

    } catch (Exception $e) {
        error_log("VarMusic PHP Error: " . $e->getMessage());
        echo json_encode(['error' => 'An unexpected server error occurred.']);
        exit();
    }
}

/**
 * Gets an Access Token from Spotify using the Client Credentials Flow (for public data/search).
 * @return array An associative array containing 'access_token' or 'error'.
 */
function getSpotifyAccessToken() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token'); // Correct Spotify token endpoint
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'client_credentials'
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode(SPOTIFY_CLIENT_ID . ':' . SPOTIFY_CLIENT_SECRET),
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (curl_errno($ch)) {
        return ['error' => 'cURL Error: ' . curl_error($ch)];
    }

    $data = json_decode($response, true);

    if ($httpCode !== 200 || !isset($data['access_token'])) {
        return ['error' => $data['error_description'] ?? 'Unknown token error (HTTP ' . $httpCode . ').'];
    }

    return $data;
}

/**
 * Performs a search on the Spotify Web API.
 * @param string $query The search query.
 * @param string $type Comma-separated list of item types to search across.
 * @param string $accessToken The Spotify access token.
 * @return array An associative array of search results or an error.
 */
function spotifySearch($query, $type, $accessToken) {
    $ch = curl_init();
    $encodedQuery = urlencode($query);
    curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q={$encodedQuery}&type={$type}&limit=10"); // Correct Spotify search endpoint
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (curl_errno($ch)) {
        return ['error' => 'cURL Error: ' . curl_error($ch)];
    }

    $data = json_decode($response, true);

    if ($httpCode !== 200) {
        $errorMessage = $data['error']['message'] ?? 'Unknown search error.';
        $errorCode = $data['error']['status'] ?? 'N/A';
        return ['error' => "Spotify API Error ($errorCode): {$errorMessage}"];
    }

    return $data;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VarMusic - Music Hub</title>
    <style>
        /* Basic styling for VarMusic (same as before) */
        :root {
            --bg: #121212; /* Dark background */
            --card: #181818; /* Slightly lighter for cards/containers */
            --navbar-bg: #000; /* Even darker for nav-like elements */
            --input-bg: #282828; /* Input field background */
            --input-border: #363636; /* Input field border */
            --input-focus-border: #007bff; /* Accent color for focus/hover */
            --accent: #1DB954; /* Spotify green */
            --text: #ffffff; /* Main text color */
            --secondary-text: #b3b3b3; /* Lighter text for secondary info */
            --box-shadow-medium: rgba(0, 0, 0, 0.5); /* Shadow for dark mode */
        }

        body.light-mode {
            --bg: #f0f2f5;
            --card: #ffffff;
            --navbar-bg: #e0e2e5;
            --input-bg: #f9f9f9;
            --input-border: #ddd;
            --input-focus-border: #007bff;
            --accent: #1DB954;
            --text: #2d3748;
            --secondary-text: #718096;
            --box-shadow-medium: rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: var(--bg);
            color: var(--text);
            justify-content: center;
            align-items: flex-start; /* Align to top, not center */
            font-size: 16px; /* Base font size */
        }
        .main-wrapper {
            background-color: var(--card);
            border-radius: 8px;
            box-shadow: 0 0 10px var(--box-shadow-medium);
            padding: 30px;
            margin: 20px;
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 20px; /* Spacing between sections */
        }
        .music-header {
            text-align: center;
        }
        .music-header h1 {
            color: var(--accent);
            margin: 0 0 5px 0;
            font-size: 2.5em; /* Larger heading */
        }
        .music-header p {
            color: var(--secondary-text);
            font-size: 1.1em;
        }
        .login-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-section .spotify-login-btn {
            background-color: #1DB954; /* Spotify green */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px; /* Pill shape */
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none; /* For the link */
            display: inline-block; /* For proper padding and alignment */
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 0 auto;
        }
        .login-section .spotify-login-btn:hover {
            background-color: #1ed760;
        }
        .login-section .spotify-login-btn img {
            width: 24px; /* Spotify logo size */
            height: 24px;
        }
        .user-status {
            text-align: center;
            margin-top: 15px;
            color: var(--secondary-text);
        }
        .search-section {
            display: flex;
            gap: 10px;
            flex-wrap: wrap; /* Allow wrapping on small screens */
        }
        .search-section input[type="text"] {
            flex-grow: 1;
            padding: 12px 15px;
            border: 1px solid var(--input-border);
            border-radius: 5px;
            background-color: var(--input-bg);
            color: var(--text);
            font-size: 1em;
            min-width: 200px; /* Ensure input is not too small */
        }
        .search-section input[type="text"]:focus {
            outline: none;
            border-color: var(--input-focus-border);
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .search-section button {
            padding: 12px 25px;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        .search-section button:hover {
            background-color: #1ed760; /* Slightly lighter green on hover */
        }
        .search-section button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            opacity: 0.7;
        }
        .results-container {
            min-height: 100px;
            background-color: var(--bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            padding: 20px;
            overflow-y: auto;
            max-height: 600px; /* Limit height for scrollability */
        }
        .results-container h2 {
            color: var(--accent);
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.5em;
            border-bottom: 1px solid var(--input-border);
            padding-bottom: 5px;
        }
        .result-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            background-color: var(--input-bg);
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: background-color 0.2s ease;
        }
        .result-item:hover {
            background-color: var(--input-focus-border);
        }
        body.dark-mode .result-item:hover {
             background-color: #3b4558;
        }
        .result-item img {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            margin-right: 15px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .result-info {
            flex-grow: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .result-info h3 {
            margin: 0;
            color: var(--text);
            font-size: 1.1em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .result-info p {
            margin: 0;
            color: var(--secondary-text);
            font-size: 0.9em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .result-info a {
            color: var(--accent);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s ease;
            display: inline-block;
            margin-top: 5px;
        }
        .result-info a:hover {
            color: #1ed760;
            text-decoration: underline;
        }
        .audio-player {
            margin-left: auto;
            flex-shrink: 0;
            width: 150px;
        }
        .audio-player audio {
            width: 100%;
            height: 30px;
            background-color: var(--input-bg);
            border-radius: 5px;
            /* Filter can sometimes mess with default controls, remove if problematic */
            /* filter: invert(1); */
        }
        .error-message, .info-message {
            color: #d32f2f;
            background-color: #ffe0e0;
            border: 1px solid #d32f2f;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }
        .info-message {
            color: #007bff;
            background-color: #e0f2ff;
            border-color: #007bff;
        }
        .loading-message {
            text-align: center;
            color: var(--secondary-text);
            font-style: italic;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .main-wrapper {
                margin: 10px;
                padding: 20px;
            }
            .music-header h1 {
                font-size: 2em;
            }
            .search-section {
                flex-direction: column;
            }
            .search-section input[type="text"],
            .search-section button {
                width: 100%;
            }
            .result-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px;
            }
            .result-item img {
                margin-right: 0;
                margin-bottom: 10px;
                width: 50px;
                height: 50px;
            }
            .result-info h3, .result-info p {
                white-space: normal;
                overflow: visible;
                text-overflow: clip;
            }
            .audio-player {
                margin-left: 0;
                margin-top: 10px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="music-header">
            <h1>VarMusic</h1>
            <p>Discover and learn about your favorite music!</p>
        </div>

        <div class="login-section">
            <?php if (isset($_SESSION['spotify_access_token'])): ?>
                <p class="user-status">Logged in to Spotify as: <?php echo htmlspecialchars($_SESSION['spotify_user_display_name'] ?? 'User'); ?></p>
                <?php else: ?>
                <!-- <a href="?action=login" class="spotify-login-btn">
                    <img src="https://storage.googleapis.com/pr-newsroom-wp/1/2023/05/Spotify_Primary_Logo_RGB_Green.png" alt="Spotify Logo">
                    Login with Spotify
                </a> -->
                <!-- <p class="user-status">Log in to play full songs (Premium required).</p> -->
            <?php endif; ?>
        </div>

        <div class="search-section">
            <input type="text" id="music-search-input" placeholder="Search for songs, artists, or albums...">
            <button id="search-button">Search</button>
        </div>
        <div class="results-container" id="music-results">
            <p class="info-message">Start by searching for an artist or song!</p>
        </div>
    </div>

    <script>
        // (JavaScript part remains exactly the same as previous version for now)
        // We will update this later to handle full playback with the SDK.

        const musicSearchInput = document.getElementById('music-search-input');
        const searchButton = document.getElementById('search-button');
        const musicResults = document.getElementById('music-results');

        searchButton.addEventListener('click', performSearch);
        musicSearchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });

        async function performSearch() {
            const query = musicSearchInput.value.trim();
            if (query === '') {
                displayMessage("Please enter a search query.", 'error');
                return;
            }

            musicSearchInput.disabled = true;
            searchButton.disabled = true;
            musicResults.innerHTML = '<p class="loading-message">Searching Spotify...</p>';

            try {
                const response = await fetch('varmusic.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `query=${encodeURIComponent(query)}&type=track,artist,album`
                });

                const data = await response.json();

                if (data.error) {
                    displayMessage(`Error: ${data.error}`, 'error');
                } else {
                    displayResults(data.results);
                }
            } catch (error) {
                console.error('Fetch error:', error);
                displayMessage('An error occurred during the search. Please try again.', 'error');
            } finally {
                musicSearchInput.disabled = false;
                searchButton.disabled = false;
                musicSearchInput.focus();
            }
        }

        function displayResults(results) {
            musicResults.innerHTML = '';

            let hasResults = false;

            // --- Display Tracks ---
            if (results.tracks && results.tracks.items.length > 0) {
                const trackHeader = document.createElement('h2');
                trackHeader.textContent = 'Tracks';
                musicResults.appendChild(trackHeader);
                results.tracks.items.forEach(track => {
                    const item = document.createElement('div');
                    item.classList.add('result-item');
                    const imageUrl = track.album.images.length > 0 ? track.album.images[track.album.images.length - 1].url : 'https://via.placeholder.com/60?text=No+Image';

                    let audioPlayerHtml = '';
                    if (track.preview_url) {
                        audioPlayerHtml = `
                            <div class="audio-player">
                                <audio controls>
                                    <source src="${track.preview_url}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        `;
                    }

                    item.innerHTML = `
                        <img src="${imageUrl}" alt="${track.name} Album Art">
                        <div class="result-info">
                            <h3>${track.name}</h3>
                            <p>Artist: ${track.artists.map(artist => artist.name).join(', ')}</p>
                            <p>Album: ${track.album.name}</p>
                            ${track.external_urls.spotify ? `<a href="${track.external_urls.spotify}" target="_blank">Listen on Spotify</a>` : ''}
                        </div>
                        ${audioPlayerHtml}
                    `;
                    musicResults.appendChild(item);
                    hasResults = true;
                });
            }

            // --- Display Artists ---
            if (results.artists && results.artists.items.length > 0) {
                const artistHeader = document.createElement('h2');
                artistHeader.textContent = 'Artists';
                musicResults.appendChild(artistHeader);
                results.artists.items.forEach(artist => {
                    const item = document.createElement('div');
                    item.classList.add('result-item');
                    const imageUrl = artist.images.length > 0 ? artist.images[artist.images.length - 1].url : 'https://via.placeholder.com/60?text=No+Image';
                    item.innerHTML = `
                        <img src="${imageUrl}" alt="${artist.name} Image">
                        <div class="result-info">
                            <h3>${artist.name}</h3>
                            <p>Followers: ${artist.followers ? artist.followers.total.toLocaleString() : 'N/A'}</p>
                            ${artist.external_urls.spotify ? `<a href="${artist.external_urls.spotify}" target="_blank">View on Spotify</a>` : ''}
                        </div>
                    `;
                    musicResults.appendChild(item);
                    hasResults = true;
                });
            }

            // --- Display Albums ---
            if (results.albums && results.albums.items.length > 0) {
                const albumHeader = document.createElement('h2');
                albumHeader.textContent = 'Albums';
                musicResults.appendChild(albumHeader);
                results.albums.items.forEach(album => {
                    const item = document.createElement('div');
                    item.classList.add('result-item');
                    const imageUrl = album.images.length > 0 ? album.images[album.images.length - 1].url : 'https://via.placeholder.com/60?text=No+Image';
                    item.innerHTML = `
                        <img src="${imageUrl}" alt="${album.name} Album Art">
                        <div class="result-info">
                            <h3>${album.name}</h3>
                            <p>Artist: ${album.artists.map(artist => artist.name).join(', ')}</p>
                            <p>Release Year: ${album.release_date ? album.release_date.substring(0, 4) : 'N/A'}</p>
                            ${album.external_urls.spotify ? `<a href="${album.external_urls.spotify}" target="_blank">View on Spotify</a>` : ''}
                        </div>
                    `;
                    musicResults.appendChild(item);
                    hasResults = true;
                });
            }


            if (!hasResults) {
                displayMessage("No results found for your query. Try something else!", 'info');
            }
        }

        function displayMessage(message, type = 'info') {
            musicResults.innerHTML = `<p class="${type}-message">${message}</p>`;
        }
    </script>
    <script src="theme.js"></script>
</body>
</html>