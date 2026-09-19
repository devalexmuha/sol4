// Like / unlike any post from any view (feed cards, single post).
// Delegated so it also covers cards rendered anywhere on the page.

import { isAuthed, jsonHeaders } from './config.js';
import { openAuthModal } from './auth-modal.js';

const COOLDOWN_MS = 700;
const lastClickByBtn = new WeakMap();

function paint(btn, liked, count) {
    btn.dataset.liked = liked ? 'true' : 'false';
    btn.setAttribute('aria-pressed', liked ? 'true' : 'false');

    const icon = btn.querySelector('[data-like-icon]');
    if (icon) icon.setAttribute('fill', liked ? 'currentColor' : 'none');

    if (typeof count === 'number') {
        const countEl = btn.querySelector('[data-like-count]');
        if (countEl) countEl.textContent = count;
    }
}

async function toggle(btn) {
    if (!isAuthed()) {
        openAuthModal('You need to be signed in to like transmissions.');
        return;
    }

    const now = Date.now();
    if (now - (lastClickByBtn.get(btn) || 0) < COOLDOWN_MS) return;
    if (btn.dataset.loading === 'true') return;
    lastClickByBtn.set(btn, now);

    const liked = btn.dataset.liked === 'true';
    const method = liked ? 'DELETE' : 'POST';

    btn.dataset.loading = 'true';

    // Optimistic flip so it feels instant.
    const prevCount = Number(btn.querySelector('[data-like-count]')?.textContent || 0);
    paint(btn, !liked, liked ? prevCount - 1 : prevCount + 1);

    try {
        const res = await fetch(btn.dataset.endpoint, { method, headers: jsonHeaders() });
        if (!res.ok) throw new Error(`Like request failed: ${res.status}`);
        const data = await res.json();
        paint(btn, data.liked, data.likes_count);
    } catch (err) {
        console.error(err);
        paint(btn, liked, prevCount); // roll back
    } finally {
        btn.dataset.loading = 'false';
    }
}

export function initLikes() {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-like-toggle]');
        if (btn) {
            e.preventDefault();
            toggle(btn);
        }
    });
}
