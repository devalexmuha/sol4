// Subscribe / unsubscribe toggle on a profile page.

import { jsonHeaders } from './config.js';

const SUBSCRIBED_CLASSES = ['border', 'border-sol-line', 'bg-sol-paper', 'text-sol-muted', 'hover:border-sol-mars', 'hover:text-sol-mars'];
const UNSUBSCRIBED_CLASSES = ['bg-sol-orange', 'text-sol-panel', 'hover:bg-sol-mars'];
const COOLDOWN_MS = 1000;

export function initSubscribe() {
    const btn = document.getElementById('subscribe-btn');
    if (!btn) return;

    const countEl = document.getElementById('subscribers-count');
    let lastClick = 0;

    const applyState = (subscribed) => {
        btn.dataset.subscribed = subscribed ? 'true' : 'false';
        btn.setAttribute('aria-pressed', subscribed ? 'true' : 'false');

        const label = btn.querySelector('[data-subscribe-label]');
        if (label) label.textContent = subscribed ? 'Subscribed' : 'Subscribe';

        if (subscribed) {
            btn.classList.remove(...UNSUBSCRIBED_CLASSES);
            btn.classList.add(...SUBSCRIBED_CLASSES);
        } else {
            btn.classList.remove(...SUBSCRIBED_CLASSES);
            btn.classList.add(...UNSUBSCRIBED_CLASSES);
        }
    };

    btn.addEventListener('click', async () => {
        if (btn.dataset.loading === 'true') return;

        const now = Date.now();
        if (now - lastClick < COOLDOWN_MS) return;
        lastClick = now;

        const subscribed = btn.dataset.subscribed === 'true';
        const method = subscribed ? 'DELETE' : 'POST';

        btn.dataset.loading = 'true';
        btn.disabled = true;

        try {
            const res = await fetch(btn.dataset.endpoint, { method, headers: jsonHeaders() });
            if (!res.ok) throw new Error(`Request failed: ${res.status}`);
            const data = await res.json();
            applyState(data.subscribed);
            if (countEl && typeof data.subscribers_count !== 'undefined') {
                countEl.textContent = data.subscribers_count;
            }
        } catch (err) {
            console.error(err);
        } finally {
            btn.dataset.loading = 'false';
            btn.disabled = false;
        }
    });
}
