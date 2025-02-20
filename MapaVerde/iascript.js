const API_URL = 'http://localhost:3000/chat';

const chatMessages = document.getElementById('chat-messages');
const userInput = document.getElementById('user-input');
const loading = document.getElementById('loading');
let isChatOpen = false;

function toggleChat() {
    const chatContainer = document.getElementById('chatContainer');
    isChatOpen = !isChatOpen;
    chatContainer.style.display = isChatOpen ? 'flex' : 'none';
}

function addMessage(message, isUser) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
    messageDiv.textContent = message;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function sendMessage() {
    const message = userInput.value.trim();
    if (!message) return;

    addMessage(message, true);
    userInput.value = '';
    loading.style.display = 'block';

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ messages: [{ role: "user", content: message }] })
        });

        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        
        const data = await response.json();
        const botResponse = data.choices[0].message.content;
        addMessage(botResponse, false);
    } catch (error) {
        addMessage(`Error: ${error.message}`, false);
        console.error(error);
    } finally {
        loading.style.display = 'none';
    }
}

userInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') sendMessage();
});
