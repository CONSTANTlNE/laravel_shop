
    function getOrCreateDeviceId() {
    let deviceId = localStorage.getItem('shopz_device_id');
    if (!deviceId) {
    // Generates a random string like 'user_123456789'
    deviceId = 'user_' + Math.random().toString(36).substring(2, 15);
    localStorage.setItem('shopz_device_id', deviceId);
}
    return deviceId;
}
    document.addEventListener('DOMContentLoaded', () => {
    // 1. UI Elements
    const chatToggle = document.getElementById('chat-toggle');
    const chatWidget = document.getElementById('chat-widget');
    const chatClose = document.getElementById('chat-close');
    const chatForm = document.getElementById('chat-form');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');

    // 2. Chatwoot Configuration
    const CHATWOOT_URL = "https://chatwoot.ews.ge";
    const INBOX_IDENTIFIER = "bu3m2GPcNh9ZktA35GJwWo2h";

    let contactSourceId = localStorage.getItem('cw_contact_source_id');
    let conversationId = localStorage.getItem('cw_conversation_id');
    let displayedMessageIds = new Set();

    // 3. UI Toggle Logic
    chatToggle.addEventListener('click', () => {
    chatWidget.classList.remove('d-none');
    // chatToggle.classList.add('d-none');
    chatInput.focus();
});

    chatClose.addEventListener('click', () => {
    chatWidget.classList.add('d-none');
    // chatToggle.classList.remove('d-none');
});

    // 4. Handle Form Submission
    chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const text = chatInput.value.trim();

    if (text !== "") {
    // Optimistically add to UI
    appendMessage(text, 'sent');
    chatInput.value = "";
    await sendMessageToChatwoot(text);
}
});

    // 5. Chatwoot API: Send Message
    async function sendMessageToChatwoot(messageText) {
    try {
    // A. Create Contact if missing
    if (!contactSourceId) {
    // 1. Get the name from Laravel (PHP)
    const authName = "{{ Auth::check() ? Auth::user()->name : '' }}";
    const deviceId = getOrCreateDeviceId();
    // 2. Use a fallback if the user is not logged in
    const finalName = authName ? authName : `Customer ${deviceId.substring(5, 10)}`;

    const res = await fetch(`${CHATWOOT_URL}/public/api/v1/inboxes/${INBOX_IDENTIFIER}/contacts`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
    name: finalName, // Example: Customer a1b2c
    identifier: deviceId, // This is the magic key for uniqueness
    custom_attributes: {
    current_page: window.location.href // Helpful for you to see what they are looking at
}
})
});
    const data = await res.json();
    contactSourceId = data.source_id;
    localStorage.setItem('cw_contact_source_id', contactSourceId);
}

    // B. Create Conversation if missing
    if (!conversationId) {
    const res = await fetch(`${CHATWOOT_URL}/public/api/v1/inboxes/${INBOX_IDENTIFIER}/contacts/${contactSourceId}/conversations`, {
    method: "POST",
    headers: { "Content-Type": "application/json" }
});
    const data = await res.json();
    conversationId = data.id;
    localStorage.setItem('cw_conversation_id', conversationId);
}

    // C. Post Message to API
    const msgRes = await fetch(`${CHATWOOT_URL}/public/api/v1/inboxes/${INBOX_IDENTIFIER}/contacts/${contactSourceId}/conversations/${conversationId}/messages`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ content: messageText })
});
    const msgData = await msgRes.json();
    displayedMessageIds.add(msgData.id);
} catch (e) { console.error("Chatwoot Error:", e); }
}

    // 6. Chatwoot API: Fetch/Poll Messages
    async function fetchMessages() {
    if (!contactSourceId || !conversationId) return;

    try {
    const res = await fetch(`${CHATWOOT_URL}/public/api/v1/inboxes/${INBOX_IDENTIFIER}/contacts/${contactSourceId}/conversations/${conversationId}/messages`);
    const messages = await res.json();

    messages.forEach(msg => {
    if (!displayedMessageIds.has(msg.id)) {
    // 0 = Customer, 1 = Agent
    const type = msg.message_type === 1 ? 'received' : 'sent';
    appendMessage(msg.content, type);
    displayedMessageIds.add(msg.id);
}
});
} catch (e) { console.error("Poll Error:", e); }
}

    // 7. UI: Append to Screen
    function appendMessage(text, type) {
    const isSent = type === 'sent';
    const msgDiv = document.createElement('div');
    msgDiv.className = `mb-3 ${isSent ? 'text-end' : 'text-start'}`;
    msgDiv.innerHTML = `
            <div class="${isSent ? 'bg-primary text-white' : 'bg-white border text-dark'} p-2 rounded shadow-sm d-inline-block" style="max-width: 80%; word-wrap: break-word;">
                ${text}
            </div>
        `;
    chatMessages.appendChild(msgDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

    // Initial Load & Polling
    let pollInterval;

    function startPolling() {

    if (!pollInterval) {
    // Fetch immediately when they open/return
    fetchMessages();
    // Then every 5 seconds
    pollInterval = setInterval(fetchMessages, 5000);
}
}

    function stopPolling() {
    clearInterval(pollInterval);
    pollInterval = null;
}

// 1. Initial Load Logic
    if (conversationId) {
    if (document.visibilityState === 'visible') {

    startPolling();
}
}

// 2. Tab Switch Logic (The missing piece)
    document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
    console.log('startPolling');
    startPolling();
} else {
    console.log('stopPolling');
    stopPolling();
}
});


});

