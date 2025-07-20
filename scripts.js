// script.js

document.addEventListener('DOMContentLoaded', () => {
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-button');
    const chatMessages = document.getElementById('chat-messages');
    const ruleBrokenMessage = document.getElementById('rule-broken-message');

    let isRuleBroken = false; // State variable to track rule violations

    // Define rules for Hack Club AI (these are examples, refine as needed)
    // Based on the terms: "Projects only - no personal use."
    // "Abuse means this will get shut down."
    const hackClubRules = [
        /personal use/i,
        /my life/i,
        /tell me about myself/i,
        /write a poem about me/i,
        /dating advice/i,
        /illegal/i, // General abuse prevention
        /harmful/i,
        /violence/i,
        /hate speech/i,
        /spam/i,
        /phishing/i,
        /exploit/i,
        /crack/i,
        /warez/i,
        /torrent/i, // Potentially for illegal content
        // Add more specific patterns if abuse types are identified.
        // E.g., specific keywords related to non-project tasks.
    ];

    // Function to check if a message breaks rules
    function checkRules(message) {
        for (const rule of hackClubRules) {
            if (rule.test(message)) {
                return true; // Rule broken
            }
        }
        return false; // No rule broken
    }

    // Function to append a message to the chat
    function appendMessage(sender, text, isCode = false) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', sender);

        const contentWrapper = document.createElement('div');
        contentWrapper.classList.add('message-content-wrapper');

        // Sanitize input if it's user input to prevent XSS.
        // For AI output, we assume it's controlled or we want to allow specific HTML (like pre/code).
        // If the AI can output arbitrary HTML, you'll need a more robust sanitization library.
        if (sender === 'user') {
            contentWrapper.textContent = text;
        } else {
            // For AI messages, use innerHTML to allow pre-formatted code or MathJax.
            contentWrapper.innerHTML = text;
        }

        messageDiv.appendChild(contentWrapper);

        // Add copy button for AI messages with code blocks (identified by isCode flag)
        if (sender === 'ai' && isCode) {
            const copyButton = document.createElement('button');
            copyButton.classList.add('copy-button');
            copyButton.textContent = 'Copy Code';
            copyButton.onclick = () => {
                // Find the first <code> element within a <pre> block in the message
                const codeElement = messageDiv.querySelector('pre code');
                if (codeElement) {
                    navigator.clipboard.writeText(codeElement.textContent)
                        .then(() => {
                            copyButton.textContent = 'Copied!';
                            setTimeout(() => copyButton.textContent = 'Copy Code', 2000);
                        })
                        .catch(err => console.error('Failed to copy text: ', err));
                }
            };
            messageDiv.appendChild(copyButton);
        }

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to bottom

        // Re-run MathJax typesetting for new content
        if (window.MathJax) {
            // Typeset only the new message element for efficiency
            MathJax.typesetPromise([messageDiv]);
        }

        // Re-run Prism.js highlighting for new code blocks
        if (window.Prism) {
            // Highlight only new code blocks within the message
            const codeBlocks = messageDiv.querySelectorAll('pre code');
            codeBlocks.forEach(block => Prism.highlightElement(block));
        }
    }

    // Function to disable input and show rule broken message
    function triggerRuleBroken() {
        isRuleBroken = true;
        userInput.disabled = true;
        sendButton.disabled = true;
        ruleBrokenMessage.classList.remove('hide'); // Show the message
        appendMessage('ai', "I'm sorry, I cannot process that request as it violates the Hack Club AI terms of service. Please refresh the page to continue using the chatbot under the allowed guidelines.", false);
    }

    // Main send message function
    async function sendMessage() {
        if (isRuleBroken) {
            // If rules are already broken, prevent sending
            appendMessage('ai', "You have violated the rules. Please refresh the page.", false);
            return;
        }

        const message = userInput.value.trim();
        if (message === '') return; // Don't send empty messages

        appendMessage('user', message); // Display user's message immediately
        userInput.value = ''; // Clear input field

        // --- Rule/Command Checks BEFORE API Call ---

        // 1. Check for "shush" command
        if (message.toLowerCase().includes('shush') || message.toLowerCase().includes('be quiet')) {
            appendMessage('ai', "Alright, I'll be quiet now. Let me know if you need anything else later!", false);
            return; // Stop processing, no API call needed
        }

        // 2. Check against Hack Club AI rules
        if (checkRules(message)) {
            triggerRuleBroken(); // Apply broken state and message
            return; // Stop processing, do not send to AI
        }

        // --- API Call to Hack Club AI ---

        // Show typing indicator while waiting for AI response
        const typingIndicator = document.createElement('div');
        typingIndicator.classList.add('message', 'ai', 'typing-indicator');
        typingIndicator.innerHTML = '<div class="message-content-wrapper">Thinking...</div>'; // Simple text indicator
        chatMessages.appendChild(typingIndicator);
        chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to view indicator

        try {
            const response = await fetch('https://ai.hackclub.com/chat/completions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    messages: [{ role: 'user', content: message }],
                }),
            });

            // Remove typing indicator as soon as response is received (or error)
            typingIndicator.remove();

            if (!response.ok) {
                // Handle non-2xx HTTP responses
                const errorDetail = await response.text(); // Get error message from API if any
                console.error('Hack Club AI API Error:', response.status, errorDetail);
                appendMessage('ai', `Error: Could not get a response from VarAI. (Status: ${response.status}) Please try again later.`, false);
                return;
            }

            const data = await response.json();
            const aiResponseContent = data.choices[0].message.content;

            // Simple heuristic to detect if AI response contains code blocks (for copy button)
            const isCodeResponse = aiResponseContent.includes('```');

            appendMessage('ai', aiResponseContent, isCodeResponse);

        } catch (error) {
            console.error('Network or Fetch Error:', error);
            // Ensure typing indicator is removed even if network error occurs
            typingIndicator.remove();
            appendMessage('ai', 'Oops! Something went wrong while connecting to VarAI. Please check your internet connection or try again.', false);
        }
    }

    // Event Listeners
    sendButton.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) { // Send on Enter, allow Shift+Enter for new line
            e.preventDefault(); // Prevent default Enter behavior (e.g., new line in textarea)
            sendMessage();
        }
    });

    // Initial message on load (already in varai.php, so not needed here unless dynamic)
    // appendMessage('ai', "Hello! I'm VarAI. How can I assist you today?");

    // Optional: If you had pre-existing code blocks that needed highlighting on page load
    // For a fresh chat, the initial AI message is simple text, so this isn't strictly necessary
    // but good practice if you dynamically load past conversations.
    // document.querySelectorAll('.message.ai pre code').forEach(block => Prism.highlightElement(block));
});