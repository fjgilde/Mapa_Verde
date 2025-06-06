document.addEventListener('DOMContentLoaded', () => {
  const chatIcon = document.getElementById('chat-icon');
  const chatContainer = document.getElementById('chat-container');
  const userInput = document.getElementById('user-input');
  const sendBtn = document.getElementById('send-btn');
  const chatMessages = document.getElementById('chat-messages');
  const loading = document.getElementById('loading');

  let isChatOpen = false;
  let messageHistory = [];

  const toggleChat = () => {
      isChatOpen = !isChatOpen;
      chatContainer.style.display = isChatOpen ? 'flex' : 'none';
      chatIcon.style.transform = isChatOpen ? 'rotate(360deg)' : 'none';
      if (isChatOpen) userInput.focus();
  };

  const addMessage = (content, isUser) => {
      const messageDiv = document.createElement('div');
      messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
      messageDiv.innerHTML = `
          <div class="message-content">${content}</div>
          <div class="message-time">${new Date().toLocaleTimeString()}</div>
      `;
      chatMessages.appendChild(messageDiv);
      chatMessages.scrollTop = chatMessages.scrollHeight;
  };

  const sendMessage = async () => {
      const message = userInput.value.trim();
      if (!message) return;

      addMessage(message, true);
      userInput.value = '';
      loading.style.display = 'block';

      try {
          const response = await fetch('http://localhost:3000/chat', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                  messages: [{ role: "user", content: message }]
              })
          });

          const data = await response.json();
          addMessage(data.content, false);

      } catch (error) {
          addMessage(`Error: ${error.message}`, false);
      } finally {
          loading.style.display = 'none';
      }
  };

  chatIcon.addEventListener('click', toggleChat);
  sendBtn.addEventListener('click', sendMessage);
  userInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') sendMessage();
  });
});