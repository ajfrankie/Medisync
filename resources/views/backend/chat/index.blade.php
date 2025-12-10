@extends('backend.layouts.master')

@section('title') @lang('translation.Chat') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Medisync @endslot
@slot('title') Chat @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="d-flex align-items-center p-3 border-bottom">
                    <div>
                        <h5 class="mb-0">AI Assistant</h5>
                        <small class="text-muted">Ask general questions or describe symptoms (comma separated).</small>
                    </div>
                    <div class="ms-auto">
                        <button id="btn-clear" class="btn btn-sm btn-outline-secondary">Clear chat</button>
                    </div>
                </div>

                <div id="chat-area" class="p-3" style="height:520px; overflow-y:auto; background:#F7F9FB;">
                    <ul id="messages" class="list-unstyled mb-0">
                        <!-- messages appended here -->
                    </ul>
                </div>

                <div class="p-3 border-top">
                    <form id="chat-form" class="row g-2" autocomplete="off">
                        @csrf
                        <div class="col">
                            <input id="chat-input" name="message" type="text" class="form-control" placeholder="Say hi, ask about symptoms (e.g. fever, cough) or 'book appointment'...">
                            <div class="form-text">Tip: send multiple symptoms separated by commas (e.g. "fever, cough, headache").</div>
                        </div>
                        <div class="col-auto">
                            <button id="send-btn" type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Clean left/right bubbles */
.msg-row { display:flex; margin-bottom:12px; }
.msg-left { justify-content:flex-start; }
.msg-right { justify-content:flex-end; }
.bubble { max-width:78%; padding:12px 14px; border-radius:14px; box-shadow:0 1px 2px rgba(16,24,40,0.05); font-size:14px; }
.bubble-left { background: #ffffff; border:1px solid #eef2f6; border-bottom-left-radius:4px; }
.bubble-right { background: linear-gradient(90deg,#67b26f,#4ca2cd); color:white; border-bottom-right-radius:4px; }
.meta { margin-top:6px; font-size:12px; color:#6b7280; }
.time { font-size:11px; color:#94a3b8; margin-left:8px; }
.system-note { text-align:center; color:#64748b; font-size:12px; margin:10px 0; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const messagesEl = document.getElementById('messages');
    const chatArea = document.getElementById('chat-area');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const clearBtn = document.getElementById('btn-clear');

    const scrollToBottom = () => { chatArea.scrollTop = chatArea.scrollHeight; };

    // Helper to render a message
    function renderMessage({ who = 'ai', text = '', time = null }) {
        const li = document.createElement('li');
        li.className = 'msg-row ' + (who === 'user' ? 'msg-right' : 'msg-left');

        const wrap = document.createElement('div');
        wrap.className = 'bubble ' + (who === 'user' ? 'bubble-right' : 'bubble-left');
        wrap.innerHTML = '<div>' + escapeHtml(text).replace(/\n/g, '<br>') + '</div>' +
            '<div class="meta text-end"><span class="time">' + (time || new Date().toLocaleTimeString()) + '</span></div>';

        li.appendChild(wrap);
        messagesEl.appendChild(li);
        scrollToBottom();
    }

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/\'/g, '&#039;');
    }

    // Load history
    async function loadHistory() {
        try {
            const res = await fetch("{{ route('admin.ai-chat.history') }}", {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) throw new Error('Failed to load');
            const data = await res.json(); // expected: [{query_text, response_text, created_at, from}] 
            messagesEl.innerHTML = '';
            if (data.length === 0) {
                const note = document.createElement('div');
                note.className = 'system-note';
                note.textContent = 'No previous chats. Say hi to start.';
                chatArea.prepend(note);
            }
            data.forEach(item => {
                renderMessage({ who: 'user', text: item.query_text, time: new Date(item.created_at).toLocaleTimeString() });
                if (item.response_text) renderMessage({ who: 'ai', text: item.response_text, time: new Date(item.created_at).toLocaleTimeString() });
            });
        } catch (err) {
            console.error(err);
        }
    }

    loadHistory();

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        // show user message immediately
        renderMessage({ who: 'user', text });
        input.value = '';

        // show typing indicator
        const typingId = 'typing-' + Date.now();
        renderMessage({ who: 'ai', text: 'AI is typing...' });

        try {
            const token = document.querySelector('input[name="_token"]').value;
            const res = await fetch("{{ route('admin.ai-chat.send') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ message: text })
            });

            if (!res.ok) throw new Error('Network response was not ok');
            const payload = await res.json(); // expected { reply: '...', saved: true }

            // remove last AI typing bubble and replace with real reply
            // simplest approach: remove last element if it contains 'AI is typing...'
            const last = messagesEl.lastElementChild;
            if (last && last.innerText.includes('AI is typing')) last.remove();

            renderMessage({ who: 'ai', text: payload.reply || 'Sorry, I could not generate a reply.' });

        } catch (err) {
            // replace typing with error
            const last = messagesEl.lastElementChild;
            if (last && last.innerText.includes('AI is typing')) last.remove();
            renderMessage({ who: 'ai', text: 'Error: Unable to reach server. Try again later.' });
            console.error(err);
        }
    });

    // Clear chat button (frontend only)
    clearBtn.addEventListener('click', function () {
        if (!confirm('Clear local chat view? This does not delete server logs.')) return;
        messagesEl.innerHTML = '';
    });

    // make Enter send (already handled) and Shift+Enter for newline
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendBtn.click();
        }
    });

});
</script>

@endsection
