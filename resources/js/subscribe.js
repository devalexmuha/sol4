const btn = document.getElementById('subscribe-btn');
const countEl = document.getElementById('subscribers-count');

const COOLDOWN_MS = 1000;
let lastClick = 0;

// Class sets matching the two button states in the Blade view
const SUBSCRIBED_CLASSES = ['border', 'border-sol-line', 'bg-sol-paper', 'text-sol-muted', 'hover:border-sol-mars', 'hover:text-sol-mars'];
const UNSUBSCRIBED_CLASSES = ['bg-sol-orange', 'text-sol-panel', 'hover:bg-sol-mars'];

function applyState(subscribed) {
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
}

if (btn) {
    btn.addEventListener('click', async () => {
        // Block if a request is already in flight
        if (btn.dataset.loading === 'true') return;

        // Rate limit: at most one action per second
        const now = Date.now();
        if (now - lastClick < COOLDOWN_MS) return;
        lastClick = now;

        const subscribed = btn.dataset.subscribed === 'true';
        const method = subscribed ? 'DELETE' : 'POST';

        btn.dataset.loading = 'true';
        btn.disabled = true;

        try {
            const res = await fetch(btn.dataset.endpoint, {
                method,
                headers: {
                    'X-CSRF-TOKEN': btn.dataset.csrf,
                    'Accept': 'application/json',
                },
            });

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
