<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// --- Backend Logic to Handle AI API Call ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['messages'])) { // Changed from 'message' to 'messages'
    // Clear output buffer to prevent stray characters before JSON
    ob_clean();

    header('Content-Type: application/json');

    // Decode the JSON string of messages from the frontend
    $messagesJson = $_POST['messages'];
    $conversationMessages = json_decode($messagesJson, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Decode Error (messages): " . json_last_error_msg());
        echo json_encode(['error' => 'Invalid messages format received.']);
        exit();
    }

    // Ensure it's an array and contains valid message objects
    if (!is_array($conversationMessages) || empty($conversationMessages)) {
        echo json_encode(['error' => 'No valid messages provided.']);
        exit();
    }

    $response = '';

    try {
        $ch = curl_init();

        // Hack Club AI Chat Completions API endpoint
        $url = 'https://ai.hackclub.com/chat/completions';

        // Use the received conversation messages directly
        // This array now contains the full history: [{"role": "user", "content": "msg"}, {"role": "assistant", "content": "reply"}, ...]
        $data = [
            'messages' => $conversationMessages
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $apiResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $response = 'Curl error: ' . curl_error($ch);
            error_log("Hack Club AI Curl Error: " . $response);
            echo json_encode(['error' => 'API connection error.']);
            exit();
        }

        curl_close($ch);

        $responseData = json_decode($apiResponse, true);

        if ($httpCode !== 200) {
            $errorDetail = $responseData['error'] ?? $apiResponse;
            $response = "API Error ($httpCode): " . (is_array($errorDetail) ? json_encode($errorDetail) : $errorDetail);
            error_log("Hack Club AI Error ($httpCode): " . $apiResponse);
            echo json_encode(['error' => $response]);
            exit();
        }

        if (isset($responseData['choices'][0]['message']['content'])) {
            $response = $responseData['choices'][0]['message']['content'];
        } else {
            $response = 'Could not get a valid response from the AI. Raw: ' . $apiResponse;
            error_log("Hack Club AI Invalid Response: " . $apiResponse);
            echo json_encode(['error' => $response]);
            exit();
        }

    } catch (Exception $e) {
        $response = 'An unexpected error occurred: ' . $e->getMessage();
        error_log("Hack Club AI General Exception: " . $e->getMessage());
        echo json_encode(['error' => $response]);
        exit();
    }

    echo json_encode(['message' => $response]); // Still send just the latest AI message back to frontend
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VarAI Chatbot</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <script>
        // Global flag to ensure initial chat loading only happens once
        let initialChatLoaded = false;

        MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']]
            },
            svg: {
                fontCache: 'global'
            },
            startup: {
                pageReady: () => {
                    console.log("MathJax is ready.");
                    // This is the FIRST reliable place to load/start the chat,
                    // ensuring MathJax is fully initialized.
                    if (!initialChatLoaded) {
                        loadChats(); // Load existing chats
                        if (chatSessions.length > 0 && currentChatId && getChatById(currentChatId)) {
                            loadChat(currentChatId); // Load the saved chat if valid
                        } else {
                            startNewChat(); // Start a new one if no valid saved chat
                        }
                        initialChatLoaded = true;
                    }
                }
            }
        };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <style>
        /* Overall layout for sidebar and main chat */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: var(--bg); /* Ensure consistent background */
        }
        .main-wrapper {
            display: flex;
            width: 100%;
            max-width: 1200px; /* Max width for the entire application */
            margin: 20px auto; /* Center the wrapper */
            border-radius: 8px;
            box-shadow: 0 0 10px var(--box-shadow-medium);
            overflow: hidden; /* Contains child borders/shadows */
            background-color: var(--card); /* Background for areas not covered by sidebar/chat */
        }

        /* Chat History Sidebar */
        .chat-history-sidebar {
            width: 250px; /* Fixed width for the sidebar */
            background-color: var(--navbar-bg); /* Darker background for sidebar */
            border-right: 1px solid var(--input-border);
            display: flex;
            flex-direction: column;
            padding: 15px;
            box-sizing: border-box;
        }
        .sidebar-header {
            font-size: 1.1em;
            font-weight: bold;
            color: var(--text);
            margin-bottom: 15px;
            text-align: center;
        }
        .new-chat-button {
            width: 100%;
            padding: 10px;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            margin-bottom: 15px;
        }
        .new-chat-button:hover {
            background-color: #008bbd;
        }
        .chat-history-list {
            flex-grow: 1;
            overflow-y: auto;
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        .chat-history-list::-webkit-scrollbar { /* WebKit browsers */
            display: none;
        }
        .chat-history-item {
            padding: 10px;
            margin-bottom: 8px;
            background-color: var(--card); /* Light background for items */
            border-radius: 5px;
            cursor: pointer;
            color: var(--text);
            font-size: 0.9em;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            transition: background-color 0.2s ease, color 0.2s ease;
            display: flex; /* Make it a flex container */
            justify-content: space-between; /* Space out content and button */
            align-items: center; /* Center vertically */
        }
        .chat-item-content { /* New wrapper for name and timestamp */
            flex-grow: 1; /* Allows content to take up available space */
            overflow: hidden; /* For ellipsis on name */
            white-space: nowrap;
            text-overflow: ellipsis;
            padding-right: 5px; /* Give some space before the button */
        }
        .chat-history-item:hover {
            background-color: var(--input-focus-border); /* Highlight on hover */
            color: white; /* Text color on hover */
        }
        .chat-history-item.active {
            background-color: var(--accent); /* Active item highlight */
            color: white;
            font-weight: bold;
        }
        .chat-history-item .timestamp {
            font-size: 0.75em;
            color: var(--secondary-text);
            margin-top: 5px;
            display: block;
        }
        .chat-history-item.active .timestamp {
             color: rgba(255, 255, 255, 0.7); /* Lighter timestamp for active */
        }
        .delete-chat-button {
            background: none;
            border: none;
            color: var(--secondary-text); /* Neutral color */
            font-size: 1.2em;
            cursor: pointer;
            padding: 0 5px;
            opacity: 0; /* Hidden by default */
            transition: opacity 0.2s ease, color 0.2s ease;
            flex-shrink: 0; /* Prevent button from shrinking */
            line-height: 1; /* Better vertical alignment for 'x' */
        }
        .chat-history-item:hover .delete-chat-button {
            opacity: 1; /* Show on hover of the entire item */
        }
        .delete-chat-button:hover {
            color: #ff4d4d; /* Red on hover */
        }

        /* Main Chat Container (existing) */
        .chat-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 400px;
            max-height: calc(100vh - 40px); /* Adjust max height for responsiveness */
        }
        .chat-header {
            background-color: var(--navbar-bg);
            padding: 15px;
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid var(--input-border);
            color: var(--text);
        }
        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: var(--bg);
            display: flex;
            flex-direction: column;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 80%;
            word-wrap: break-word;
            line-height: 1.4;
            white-space: pre-wrap; /* Preserve whitespace and line breaks */
            display: flex; /* Use flex to align content and button */
            flex-direction: column; /* Stack content and button vertically */
            position: relative;
        }
        .message.user {
            background-color: var(--accent);
            color: #fff;
            align-self: flex-end;
            margin-left: auto;
        }
        .message.ai {
            background-color: var(--input-bg-focus);
            color: var(--text);
            align-self: flex-start;
            margin-right: auto;
        }
        body.light-mode .message.ai {
            background-color: #e2e8f0;
            color: #2d3748;
        }
        .message.ai pre {
            background-color: var(--bg);
            border: 1px solid var(--input-border);
            border-radius: 5px;
            padding: 10px;
            overflow-x: auto;
            font-size: 0.9em;
            margin: 10px 0;
            font-family: 'Outfit', monospace;
            color: inherit;
        }
        .message.ai code {
            font-family: 'Outfit', monospace;
        }
        body.dark-mode .message.ai pre {
            background-color: #0d283c;
            border-color: #2c4d6a;
        }

        /* Copy Button Styling */
        .copy-button {
            background-color: var(--secondary-text);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 0.75em;
            cursor: pointer;
            margin-top: 8px;
            opacity: 0;
            transition: opacity 0.3s ease, background-color 0.3s ease;
            align-self: flex-end;
            white-space: nowrap;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .message:hover .copy-button {
            opacity: 1;
        }
        .copy-button:hover {
            background-color: #555;
        }
        body.light-mode .copy-button {
            background-color: var(--secondary-text);
            color: white;
        }
        body.light-mode .copy-button:hover {
            background-color: #5a6b7d;
        }

        .chat-input {
            display: flex;
            padding: 15px;
            border-top: 1px solid var(--input-border);
            background-color: var(--navbar-bg);
            align-items: flex-end;
        }
        .chat-input textarea {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid var(--input-border);
            border-radius: 5px;
            margin-right: 10px;
            resize: none;
            min-height: 40px;
            max-height: 120px;
            box-sizing: border-box;
            background-color: var(--card);
            color: var(--text);
        }
        .chat-input textarea:focus {
            outline: none;
            border-color: var(--input-focus-border);
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .chat-input button {
            padding: 10px 20px;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            height: 40px;
            box-sizing: border-box;
        }
        .chat-input button:hover {
            background-color: #008bbd;
        }
        .chat-input button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .error-message {
            background-color: #ffe0e0;
            color: #d32f2f;
            border: 1px solid #d32f2f;
            padding: 10px 15px;
            margin-top: 15px;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
        }
        .error-message.hide {
            display: none;
        }
        #user-input:disabled {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }
        #send-button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        body.dark-mode #user-input:disabled {
            background-color: #2d3748;
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
                margin: 0;
                border-radius: 0;
                box-shadow: none;
                max-height: 100vh;
            }
            .chat-history-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--input-border);
                max-height: 200px; /* Limit sidebar height on small screens */
                padding-bottom: 5px; /* Adjust padding */
            }
            .chat-container {
                max-height: unset; /* Let it grow to fill remaining space */
                flex-grow: 1;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="chat-history-sidebar">
            <div class="sidebar-header">Chat History</div>
            <button id="new-chat-button" class="new-chat-button">+ New Chat</button>
            <div id="chat-history-list" class="chat-history-list">
                </div>
        </div>

        <div class="chat-container">
            <div class="chat-header">VarAI Chatbot</div>
            <div class="chat-messages" id="chat-messages">
                </div>
            <div class="chat-input">
                <textarea id="user-input" placeholder="Type your message..." rows="1"></textarea>
                <button id="send-button">Send</button>
            </div>
            <div id="rule-broken-message" class="error-message hide">
                You have violated the Hack Club AI rules. Please start a new chat to continue.
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-latex.min.js"></script>
    <script>
        const chatMessages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');
        const sendButton = document.getElementById('send-button');
        const ruleBrokenMessage = document.getElementById('rule-broken-message');
        const newChatButton = document.getElementById('new-chat-button');
        const chatHistoryList = document.getElementById('chat-history-list');

        let chatSessions = []; // Array to store all chat sessions
        let currentChatId = null; // ID of the currently active chat

        const welcomeMessage = `Hello! How can I help you today? Try asking about a math formula like "$$E=mc^2$$" or code, e.g., \`\`\`python
print('Hello')
\`\`\``;

        // Define rules for Hack Club AI based on "Projects only - no personal use" and abuse prevention
        const hackClubRules = [
            // --- Creator Question Rule (NEW) ---
            {
                pattern: /\b(who made you|who created you|your creator|your developer|who is your owner|who designed you)\b/i,
                response: "I was made by Virat Sisodiya, using Meta AI from Hackclub!"
            },
            // --- Explicit Ban Phrases ---
            { pattern: /\b(ban me|disable me|shut me down|lock me|block me|stop me|terminate me)\b/i, response: null },

            // --- Personal Use / Non-Project Related ---
            { pattern: /\b(personal use|my life|my homework|my essay|my story|my resume|my personal project|my personal problem)\b/i, response: null },
            { pattern: /\b(tell me about myself|write a poem about me|dating advice|horoscope|dream interpretation|fortune telling)\b/i, response: null },
            { pattern: /\b(what is my name|remember my name|my favorite color)\b/i, response: null }, // Personal info queries
            { pattern: /\b(tell me a joke|play a game|trivia|entertain me)\b/i, response: null }, // General entertainment
            { pattern: /\b(medical advice|legal advice|financial advice|therapy|psychological help)\b/i, response: null }, // Professional advice
            { pattern: /\b(solve my math problem|do my assignment|help with my paper|write my report|help me cheat)\b/i, response: null }, // Direct homework/cheating
            // The following rules use negative lookaheads to allow these phrases IF they are explicitly for a project.
            // Example: "how to learn Python for a project" is allowed, "how to learn Python" is not.
            { pattern: /\b(how to learn|teach me about|explain to me|tutorial on|guide to)\b(?!\s*(\w+\s+)?project(s)?\b)/i, response: null }, // General learning not for a project
            { pattern: /\b(improve my code|debug my code|optimize my code)\b(?!\s*(for|in)\s*(a|my)?\s*project(s)?\b)/i, response: null }, // Code help not for a project context
            { pattern: /\b(general knowledge|random facts|what is)\b(?!\s*(\w+\s+)?project(s)?\b)/i, response: null }, // Non-project general knowledge
            { pattern: /\b(do my research|write my code|build my app)\b(?!\s*(for|in)\s*(a|my)?\s*project(s)?\b)/i, response: null }, // Delegating tasks not for project

            // --- Harmful / Abuse Synonyms (expanded) ---
            { pattern: /\b(illegal|unlawful|illicit|forbidden|prohibited|contraband|bootleg|felony|misdemeanor|criminal|fraudulent|deceptive)\b/i, response: null },
            { pattern: /\b(harmful|dangerous|hazardous|detrimental|injurious|damaging|destructive|adverse|risky|perilous|malignant)\b/i, response: null },
            { pattern: /\b(violence|violent|aggression|assault|homicide|murder|kill|torture|abuse|brutality|maim|slay|annihilate|bloodshed|genocide)\b/i, response: null },
            { pattern: /\b(hate speech|discrimination|racism|sexism|bigotry|xenophobia|homophobia|transphobia|prejudice|slur|derogatory|bigoted|offensive|intolerant)\b/i, response: null },
            { pattern: /\b(spam|spamming|junk mail|unwanted messages|mass mailing|flood attack|denial of service)\b/i, response: null },
            { pattern: /\b(phishing|scam|fraud|deception|con|trick|swindle|hoax|impersonate|spoofing)\b/i, response: null },
            { pattern: /\b(exploit|hacking|crack|pirate|warez|keygen|serial number|bypass security|vulnerability|trojan|malware|rootkit|botnet|phreaking|cyberattack)\b/i, response: null },
            { pattern: /\b(terrorist|terrorism|bomb|weapon|explosive|bioterrorism|chemical weapon|nuclear threat|assassination|insurrection|rebellion)\b/i, response: null },
            { pattern: /\b(self-harm|suicide|cutting|eating disorder|anorexia|bulimia|depression support|self-mutilation|bulemia|starve myself|hurt myself)\b/i, response: null }, // Sensitive content
            { pattern: /\b(drug trafficking|narcotics|cocaine|heroin|meth|opioids|dealer|smuggle|illicit drugs|marijuana cultivation|fentanyl|psychedelics)\b/i, response: null },
            { pattern: /\b(child abuse|child exploitation|pedophilia|molestation|grooming|child pornography|ephebophilia)\b/i, response: null },
            { pattern: /\b(bestiality|necrophilia|sexual assault|rape|non-consensual sexual act)\b/i, response: null }, // Extreme content
            { pattern: /\b(incest)\b/i, response: null }, // Extreme content
            { pattern: /\b(threaten|intimidate|harass|bully|extort|blackmail|stalk|menace|coercion)\b/i, response: null },
            { pattern: /\b(gory|gore|mutilation|dismemberment|torture porn|gruesome|macabre)\b/i, response: null },
            { pattern: /\b(explicit sexual|pornography|nude|sex act|erotic|masturbate|orgasm|intercourse|fetish|hentai)\b/i, response: null }, // Explicit content
            { pattern: /\b(cult|extremist group|radical ideology|supremacist|anarchist group)\b/i, response: null }, // Dangerous ideologies
            { pattern: /\b(misinformation|disinformation|false news|propaganda|fake news|conspiracy theory)\b/i, response: null }, // Content integrity
            { pattern: /\b(deepfake|synthetic media)\b(?!\s*(detection|analysis|research|technology))/i, response: null }, // Misuse of tech, allow study of it
        ];

        // --- Local Storage Management ---
        function generateUniqueId() {
            return 'chat_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }

        function saveChats() {
            localStorage.setItem('chatSessions', JSON.stringify(chatSessions));
            localStorage.setItem('currentChatId', currentChatId); // Save the active chat ID
        }

        function loadChats() {
            const savedSessions = localStorage.getItem('chatSessions');
            if (savedSessions) {
                chatSessions = JSON.parse(savedSessions);
            } else {
                chatSessions = [];
            }
            currentChatId = localStorage.getItem('currentChatId'); // Load the active chat ID
            renderChatHistory();
        }

        function getChatById(id) {
            return chatSessions.find(chat => chat.id === id);
        }

        function updateChatSession(id, messages, isBannedStatus) {
            const chatIndex = chatSessions.findIndex(chat => chat.id === id);
            if (chatIndex > -1) {
                chatSessions[chatIndex].messages = messages;
                if (typeof isBannedStatus !== 'undefined') { // Update isBanned status if provided
                    chatSessions[chatIndex].isBanned = isBannedStatus;
                }
                // Update name if it's still default or based on first user message
                if (chatSessions[chatIndex].name === 'New Chat' && messages.length > 1) {
                    const firstUserMessage = messages.find(msg => msg.sender === 'user');
                    if (firstUserMessage) {
                         chatSessions[chatIndex].name = firstUserMessage.text.substring(0, 30) + (firstUserMessage.text.length > 30 ? '...' : '');
                    }
                }
                chatSessions[chatIndex].timestamp = new Date().toLocaleString(); // Update timestamp
                // Move updated chat to the top of the list for "recency"
                const [movedChat] = chatSessions.splice(chatIndex, 1);
                chatSessions.unshift(movedChat);
            }
            saveChats();
            renderChatHistory();
        }

        function renderChatHistory() {
            chatHistoryList.innerHTML = '';
            chatSessions.forEach(chat => {
                const chatItem = document.createElement('div');
                chatItem.classList.add('chat-history-item');
                if (chat.id === currentChatId) {
                    chatItem.classList.add('active');
                }
                chatItem.dataset.chatId = chat.id;

                const contentWrapper = document.createElement('div');
                contentWrapper.classList.add('chat-item-content');

                const nameDiv = document.createElement('div');
                nameDiv.textContent = chat.name || 'Untitled Chat'; // Fallback name
                contentWrapper.appendChild(nameDiv);

                const timestampDiv = document.createElement('div');
                timestampDiv.classList.add('timestamp');
                timestampDiv.textContent = chat.timestamp || '';
                contentWrapper.appendChild(timestampDiv);

                chatItem.appendChild(contentWrapper);

                const deleteButton = document.createElement('button');
                deleteButton.classList.add('delete-chat-button');
                deleteButton.innerHTML = '&times;'; // 'x' icon
                deleteButton.title = 'Delete Conversation';
                deleteButton.addEventListener('click', (event) => {
                    event.stopPropagation(); // Prevent loading chat when clicking delete
                    deleteChatSession(chat.id);
                });
                chatItem.appendChild(deleteButton);

                chatItem.addEventListener('click', () => loadChat(chat.id));
                chatHistoryList.appendChild(chatItem);
            });
        }

        function deleteChatSession(chatIdToDelete) {
            if (confirm('Are you sure you want to permanently delete this conversation? This action cannot be undone.')) {
                chatSessions = chatSessions.filter(chat => chat.id !== chatIdToDelete);
                saveChats(); // Save the updated list

                if (currentChatId === chatIdToDelete) {
                    // If the deleted chat was the currently active one, start a new chat
                    startNewChat();
                } else {
                    renderChatHistory(); // Just re-render if a different chat was deleted
                }
            }
        }

        function loadChat(chatId) {
            const chat = getChatById(chatId);
            if (!chat) {
                console.error("Attempted to load non-existent chat:", chatId);
                startNewChat(); // Fallback to new chat if ID is invalid
                return;
            }

            currentChatId = chatId;
            chatMessages.innerHTML = ''; // Clear current messages

            // Restore isBanned state for the loaded chat
            const isBannedForThisChat = chat.isBanned || false; // Default to false if property doesn't exist

            if (isBannedForThisChat) {
                // If the loaded chat is banned, apply ban state immediately
                userInput.disabled = true;
                sendButton.disabled = true;
                ruleBrokenMessage.classList.remove('hide');
                addMessage("This chat has violated the Hack Club AI terms of service. Please click 'New Chat' to continue.", 'ai', false); // Don't save this error message to history
            } else {
                // If not banned, enable inputs
                userInput.disabled = false;
                sendButton.disabled = false;
                ruleBrokenMessage.classList.add('hide');
            }

            chat.messages.forEach(msg => addMessage(msg.text, msg.sender, false)); // Don't save again when loading
            userInput.focus();
            renderChatHistory(); // Update active class in sidebar
            chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to bottom
        }
        // --- End Local Storage Management ---

        // Function to check if a message breaks rules or triggers a specific response
        function checkRules(message) {
            const lowerCaseMessage = message.toLowerCase();
            for (const rule of hackClubRules) {
                if (rule.pattern.test(lowerCaseMessage)) {
                    console.log("Rule Broken by:", rule.pattern.source); // For debugging
                    return rule; // Return the rule object, including 'response' if it exists
                }
            }
            return null; // No rule matched
        }

        // Function to disable input and show rule broken message
        function triggerRuleBroken() {
            const currentChat = getChatById(currentChatId);
            if (currentChat) {
                currentChat.isBanned = true; // Mark the current chat as banned
                updateChatSession(currentChatId, currentChat.messages, true); // Save the banned status
            }

            userInput.disabled = true;
            sendButton.disabled = true;
            ruleBrokenMessage.classList.remove('hide');
            addMessage("I'm sorry, I cannot process that request as it violates the Hack Club AI terms of service. Please click 'New Chat' to continue.", 'ai', false); // Don't save this error message to history
        }

        // Function to reset the chat to a new session
        function startNewChat() {
            // Create a new chat session
            const newChat = {
                id: generateUniqueId(),
                name: 'New Chat',
                messages: [],
                timestamp: new Date().toLocaleString(),
                isBanned: false // New chats are not banned
            };
            chatSessions.unshift(newChat); // Add to the beginning
            currentChatId = newChat.id;

            chatMessages.innerHTML = ''; // Clear all messages in display
            userInput.disabled = false; // Re-enable input
            sendButton.disabled = false; // Re-enable send button
            ruleBrokenMessage.classList.add('hide'); // Hide rule broken message
            userInput.value = ''; // Clear input field
            userInput.style.height = 'auto'; // Reset textarea height

            // Add the initial AI welcome message to the display and the new chat session
            addMessage(welcomeMessage, 'ai', true); // Pass true to save this initial message
            saveChats(); // Save all chats with the new one
            renderChatHistory(); // Update sidebar
            userInput.focus();
        }

        // Function to add a message to the chat display and render its content
        // 'save' parameter controls whether the message is added to the current chat session's history
        function addMessage(text, sender, save = true) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', sender);

            const messageContentWrapper = document.createElement('div');
            messageContentWrapper.classList.add('message-content-wrapper');

            let contentForCopy = text;

            if (sender === 'ai') {
                const processedText = text.replace(/\\n/g, '\n');
                messageContentWrapper.innerHTML = marked.parse(processedText);
            } else {
                messageContentWrapper.textContent = text;
            }

            messageDiv.appendChild(messageContentWrapper);

            const copyButton = document.createElement('button');
            copyButton.textContent = 'Copy';
            copyButton.classList.add('copy-button');
            copyButton.title = 'Copy message to clipboard';

            copyButton.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(contentForCopy);
                    copyButton.textContent = 'Copied!';
                    setTimeout(() => {
                        copyButton.textContent = 'Copy';
                    }, 1500);
                } catch (err) {
                    console.error('Failed to copy text: ', err);
                    copyButton.textContent = 'Error!';
                    setTimeout(() => {
                        copyButton.textContent = 'Copy';
                    }, 1500);
                }
            });
            messageDiv.appendChild(copyButton);

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            if (sender === 'ai') {
                // Ensure MathJax is loaded and typesetPromise is available before calling
                if (window.MathJax && window.MathJax.typesetPromise) {
                    MathJax.typesetPromise([messageContentWrapper]).then(() => {
                        Prism.highlightAllUnder(messageContentWrapper);
                    }).catch(err => console.error("MathJax typesetting error:", err)); // Add error handling for typesetting
                } else {
                    // Fallback if MathJax is not ready or failed
                    console.warn("MathJax not ready, skipping typesetting for:", text);
                    Prism.highlightAllUnder(messageContentWrapper);
                }
            }

            // Save message to current session's history ONLY if 'save' is true
            // and the current chat is not banned.
            const currentChat = getChatById(currentChatId);
            if (save && currentChat && !currentChat.isBanned) {
                currentChat.messages.push({ text: text, sender: sender });
                updateChatSession(currentChatId, currentChat.messages); // Saves to localStorage
            }
        }

        sendButton.addEventListener('click', async () => {
            const currentChat = getChatById(currentChatId);
            if (currentChat && currentChat.isBanned) {
                addMessage("This chat has violated the rules. Please click 'New Chat' to continue.", 'ai', false);
                return;
            }

            const message = userInput.value.trim();
            if (message === '') return;

            addMessage(message, 'user'); // Add user message and save it (updates currentChat.messages)

            // Clear the input immediately after sending
            userInput.value = '';
            userInput.style.height = 'auto'; // Reset textarea height

            const matchedRule = checkRules(message);
            if (matchedRule) {
                if (matchedRule.response) {
                    // If a custom response is defined, use it
                    addMessage(matchedRule.response, 'ai');
                    // Do NOT send to AI API, do NOT disable inputs
                    sendButton.disabled = false;
                    userInput.disabled = false;
                    userInput.focus();
                    return; // Exit here, no further processing
                } else {
                    // If no custom response, it's a ban rule
                    triggerRuleBroken();
                    return; // Exit here
                }
            }

            // If no rule was matched, proceed with sending to AI
            sendButton.disabled = true;
            userInput.disabled = true;

            const loadingMessage = document.createElement('div');
            loadingMessage.classList.add('message', 'ai');
            loadingMessage.textContent = 'Thinking...';
            chatMessages.appendChild(loadingMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                // IMPORTANT: Get the *updated* chat session messages *after* the new user message was added
                const updatedChat = getChatById(currentChatId);
                const conversationForAI = updatedChat.messages.map(msg => ({
                    role: msg.sender === 'user' ? 'user' : 'assistant', // Map 'ai' to 'assistant'
                    content: msg.text
                }));

                const response = await fetch('varai.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    // Send the full conversation history to the PHP backend
                    body: `messages=${encodeURIComponent(JSON.stringify(conversationForAI))}`
                });

                const data = await response.json();

                chatMessages.removeChild(loadingMessage);

                if (data.error) {
                    addMessage(`Error: ${data.error}`, 'ai');
                } else {
                    addMessage(data.message, 'ai');
                }
            } catch (error) {
                console.error('Fetch error:', error);
                chatMessages.removeChild(loadingMessage);
                addMessage('An error occurred. Please try again.', 'ai', false);
            } finally {
                const afterFetchCurrentChat = getChatById(currentChatId);
                if (afterFetchCurrentChat && !afterFetchCurrentChat.isBanned) {
                    sendButton.disabled = false;
                    userInput.disabled = false;
                } else {
                    sendButton.disabled = true;
                    userInput.disabled = true;
                    ruleBrokenMessage.classList.remove('hide');
                }
                userInput.focus();
            }
        });

        userInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendButton.click();
            }
        });

        userInput.addEventListener('input', () => {
            userInput.style.height = 'auto';
            userInput.style.height = userInput.scrollHeight + 'px';
        });

        // Event listener for the new chat button
        newChatButton.addEventListener('click', startNewChat);

        // Initial setup on page load - only handles *if MathJax fails to load* or is super slow.
        // The primary chat loading is now triggered by MathJax.startup.pageReady
        document.addEventListener('DOMContentLoaded', () => {
            // Fallback for extremely rare cases where MathJax script itself doesn't load/execute pageReady
            if (!initialChatLoaded && (!window.MathJax || !window.MathJax.startup || !window.MathJax.startup.pageReady)) {
                console.warn("MathJax startup seems delayed or failed, initiating chat directly. MathJax rendering might be affected.");
                loadChats();
                if (chatSessions.length > 0 && currentChatId && getChatById(currentChatId)) {
                    loadChat(currentChatId);
                } else {
                        startNewChat();
                    }
                    initialChatLoaded = true;
                }
            });
        </script>
        <script src="theme.js"></script>
    </body>
    </html>