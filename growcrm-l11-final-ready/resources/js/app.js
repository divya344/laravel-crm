import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


if (window.Echo) {
    window.addEventListener('DOMContentLoaded', () => {
        const chatContainer = document.getElementById('chat-messages');
        if (!chatContainer) return;

        const activeUserIdInput = document.querySelector('input[name="receiver_id"]');
        const channelInput = document.querySelector('input[name="channel"]');

        const activeUserId = activeUserIdInput && activeUserIdInput.value ? activeUserIdInput.value : null;
        const activeChannel = channelInput && channelInput.value ? channelInput.value : null;

        const userIdMeta = document.querySelector('meta[name="user-id"]');
        const authUserId = userIdMeta ? userIdMeta.getAttribute('content') : null;

        function appendMessage(data, mine = false) {
            const wrapper = document.createElement('div');
            wrapper.className = 'mb-3 ' + (mine ? 'text-end' : 'text-start');

            const bubble = document.createElement('div');
            bubble.className = 'd-inline-block p-2 rounded ' + (mine ? 'bg-primary text-white' : 'bg-light');

            const header = document.createElement('div');
            header.className = 'small fw-bold';
            header.innerText = (data.sender_name || 'User') + ' · ' + (data.created_at || '');
            bubble.appendChild(header);

            if (data.body) {
                const bodyDiv = document.createElement('div');
                bodyDiv.innerText = data.body;
                bubble.appendChild(bodyDiv);
            }

            if (data.attachment_path) {
                const linkDiv = document.createElement('div');
                linkDiv.className = 'mt-1';
                const a = document.createElement('a');
                a.href = data.attachment_url || data.attachment_path;
                a.target = '_blank';
                a.innerText = 'Download attachment';
                linkDiv.appendChild(a);
                bubble.appendChild(linkDiv);
            }

            wrapper.appendChild(bubble);
            chatContainer.appendChild(wrapper);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        if (authUserId) {
            window.Echo.private('chat.user.' + authUserId)
                .listen('MessageSent', (e) => {
                    appendMessage(e);
                });
        }

        if (activeChannel) {
            window.Echo.private('chat.channel.' + activeChannel)
                .listen('MessageSent', (e) => {
                    appendMessage(e, e.sender_id == authUserId);
                });
        }
    });
}
