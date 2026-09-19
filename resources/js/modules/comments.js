// Fully client-rendered comments for a single post view.
//
// Laravel renders an empty shell; this module fetches the comments JSON,
// shows a spinner while loading, lists them, and handles create / edit /
// delete for the signed-in user. After any mutation it re-fetches the list
// (as the backend endpoints only return {success:true}).
//
// Root markup contract ([data-comments]):
//   data-endpoint   -> GET (list) + POST (create): /sol|echoes/{id}/comments
//   data-base       -> PATCH/DELETE base for a comment: /comments
//   [data-comments-list]   -> render target
//   [data-comments-count]  -> header count (optional)
//   [data-comment-form]    -> create form with a <textarea name="body"> (auth only)
//
// The post's own action counter (elsewhere on the page) is kept in sync via
// any [data-comment-count] node.

import { authId, isAuthed, jsonHeaders, mediaUrl } from './config.js';

const rtf = new Intl.RelativeTimeFormat(undefined, { numeric: 'auto' });

function timeAgo(iso) {
    const then = new Date(iso).getTime();
    if (Number.isNaN(then)) return '';
    const diff = Math.round((then - Date.now()) / 1000);
    const abs = Math.abs(diff);
    const steps = [
        [60, 'second'],
        [3600, 'minute'],
        [86400, 'hour'],
        [604800, 'day'],
        [2629800, 'week'],
        [31557600, 'month'],
        [Infinity, 'year'],
    ];
    const divisors = { second: 1, minute: 60, hour: 3600, day: 86400, week: 604800, month: 2629800, year: 31557600 };
    for (const [limit, unit] of steps) {
        if (abs < limit) return rtf.format(Math.round(diff / divisors[unit]), unit);
    }
    return '';
}

/** Tiny hyperscript helper. */
function h(tag, attrs = {}, ...children) {
    const node = document.createElement(tag);
    for (const [k, v] of Object.entries(attrs)) {
        if (v == null || v === false) continue;
        if (k === 'class') node.className = v;
        else if (k === 'text') node.textContent = v;
        else if (k.startsWith('data-') || k === 'href' || k === 'type' || k === 'rows' || k === 'aria-label' || k === 'title' || k === 'datetime')
            node.setAttribute(k, v);
        else node[k] = v;
    }
    for (const c of children) {
        if (c == null) continue;
        node.append(c.nodeType ? c : document.createTextNode(String(c)));
    }
    return node;
}

function profileName(comment) {
    return comment.user?.user_profile?.user_name || comment.user?.email || 'Explorer';
}

function avatarNode(comment) {
    const name = profileName(comment);
    const uri = comment.user?.user_profile?.media?.[0]?.media_uri;
    if (uri) {
        return h('img', {
            src: mediaUrl(uri),
            alt: name,
            class: 'size-10 shrink-0 rounded-full border border-sol-mars/30 object-cover',
        });
    }
    return h(
        'span',
        {
            class: 'grid size-10 shrink-0 place-items-center overflow-hidden rounded-full border border-sol-mars/30 bg-sol-night font-display text-sm font-bold text-sol-sand',
            'aria-label': name,
        },
        name.charAt(0).toUpperCase(),
    );
}

function ownerMenu(root, comment, article) {
    const menu = h(
        'div',
        { 'data-menu': '', class: 'hidden absolute right-0 top-full z-30 mt-1 w-28 overflow-hidden border border-sol-line bg-sol-panel shadow-sol-card' },
        h('button', {
            type: 'button', 'data-action': 'edit',
            class: 'block w-full px-4 py-2.5 text-left font-body text-[10px] font-bold uppercase tracking-[0.14em] text-sol-night transition hover:bg-sol-paper hover:text-sol-mars',
            text: 'Edit',
        }),
        h('button', {
            type: 'button', 'data-action': 'delete',
            class: 'block w-full px-4 py-2.5 text-left font-body text-[10px] font-bold uppercase tracking-[0.14em] text-sol-mars transition hover:bg-sol-paper',
            text: 'Delete',
        }),
    );

    const toggle = h(
        'button',
        {
            type: 'button', 'aria-label': 'Comment options',
            class: 'grid size-7 place-items-center rounded-full text-sol-muted transition hover:bg-sol-paper hover:text-sol-mars',
        },
        '⋯', // ⋯
    );

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        // Close any other open menus first.
        root.querySelectorAll('[data-menu]:not(.hidden)').forEach((m) => { if (m !== menu) m.classList.add('hidden'); });
        menu.classList.toggle('hidden');
    });

    menu.querySelector('[data-action="edit"]').addEventListener('click', () => {
        menu.classList.add('hidden');
        beginEdit(root, comment, article);
    });
    menu.querySelector('[data-action="delete"]').addEventListener('click', () => {
        menu.classList.add('hidden');
        removeComment(root, comment.id);
    });

    return h('div', { class: 'relative shrink-0' }, toggle, menu);
}

function commentNode(root, comment) {
    const name = profileName(comment);
    const profileHref = `/profiles/${encodeURIComponent(name)}`;
    const isOwner = comment.user_id === authId();

    const metaRow = h(
        'div',
        { class: 'flex items-center gap-2' },
        h('time', { datetime: comment.created_at, class: 'shrink-0 font-body text-[9px] font-semibold uppercase tracking-[0.14em] text-sol-muted', text: timeAgo(comment.created_at) }),
    );

    const nameRow = h(
        'div',
        { class: 'flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1' },
        h('a', { href: profileHref, class: 'truncate font-display text-base font-bold text-sol-night transition hover:text-sol-mars', text: name }),
        metaRow,
    );

    const body = h('p', { 'data-comment-body': '', class: 'mt-2 whitespace-pre-line font-body text-sm leading-6 text-sol-ink', text: comment.body });

    const column = h('div', { class: 'min-w-0 flex-1' }, nameRow, body);

    const article = h(
        'article',
        { class: 'mb-8 last:mb-0', 'data-comment-id': comment.id },
        h('div', { class: 'flex items-start gap-3' },
            h('a', { href: profileHref, class: 'shrink-0', 'aria-label': `Open ${name} profile` }, avatarNode(comment)),
            column,
        ),
    );

    if (isOwner) metaRow.append(ownerMenu(root, comment, article));

    return article;
}

function beginEdit(root, comment, article) {
    const body = article.querySelector('[data-comment-body]');
    if (!body || article.querySelector('[data-edit-form]')) return;

    const textarea = h('textarea', {
        name: 'body', rows: 2,
        class: 'block max-h-40 min-h-12 w-full resize-none border-0 border-b border-sol-line bg-transparent px-0 py-2 font-body text-sm text-sol-night outline-none transition placeholder:text-sol-muted focus:border-sol-orange focus:ring-0',
    });
    textarea.value = comment.body;

    const save = h('button', { type: 'submit', class: 'bg-sol-mars px-4 py-2 font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-panel transition hover:bg-sol-orange', text: 'Save' });
    const cancel = h('button', { type: 'button', class: 'px-2 py-2 font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted transition hover:text-sol-mars', text: 'Cancel' });

    const form = h('form', { 'data-edit-form': '', class: 'mt-2' },
        textarea,
        h('div', { class: 'mt-2 flex items-center gap-2' }, save, cancel),
    );

    body.replaceWith(form);
    textarea.focus();

    cancel.addEventListener('click', () => form.replaceWith(body));
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const value = textarea.value.trim();
        if (!value) return;
        save.disabled = true;
        await saveEdit(root, comment.id, value);
    });
}

function showSpinner(root) {
    const list = root.querySelector('[data-comments-list]');
    if (list) list.replaceChildren(h('div', { class: 'grid place-items-center py-12' }, h('div', { class: 'sol-spinner', 'aria-label': 'Loading' })));
}

function setCount(root, n) {
    root.querySelectorAll('[data-comments-count]').forEach((el) => (el.textContent = n));
    // Keep the post's own comment counter (in the actions row) in sync too.
    document.querySelectorAll('[data-comment-count]').forEach((el) => (el.textContent = n));
}

async function loadComments(root, { spinner = true } = {}) {
    if (spinner) showSpinner(root);
    try {
        const res = await fetch(root.dataset.endpoint, { headers: { Accept: 'application/json' } });
        if (!res.ok) throw new Error(`Failed to load comments: ${res.status}`);
        const comments = await res.json();
        renderList(root, comments);
    } catch (err) {
        console.error(err);
        const list = root.querySelector('[data-comments-list]');
        if (list) list.replaceChildren(h('p', { class: 'py-10 text-center font-body text-sm text-sol-mars', text: 'Could not load transmissions. Please retry.' }));
    }
}

function renderList(root, comments) {
    const list = root.querySelector('[data-comments-list]');
    if (!list) return;

    setCount(root, comments.length);

    if (!comments.length) {
        list.replaceChildren(
            h('div', { class: 'grid h-full place-items-center py-12 text-center' },
                h('div', {},
                    h('p', { class: 'font-display text-xl font-bold text-sol-night', text: 'No transmissions yet' }),
                    h('p', { class: 'mt-2 font-body text-sm text-sol-muted', text: isAuthed() ? 'Send the first comment from this sol.' : 'Sign in to send the first comment.' }),
                ),
            ),
        );
        return;
    }

    const sorted = [...comments].sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
    list.replaceChildren(...sorted.map((c) => commentNode(root, c)));
}

async function submitNew(root, form) {
    const textarea = form.querySelector('[name="body"]');
    const value = (textarea?.value || '').trim();
    if (!value) return;

    const btn = form.querySelector('button[type="submit"]');
    if (btn) btn.disabled = true;

    try {
        const fd = new FormData();
        fd.append('body', value);
        const res = await fetch(root.dataset.endpoint, { method: 'POST', headers: jsonHeaders(), body: fd });
        if (!res.ok) throw new Error(`Comment failed: ${res.status}`);
        if (textarea) textarea.value = '';
        await loadComments(root);
    } catch (err) {
        console.error(err);
    } finally {
        if (btn) btn.disabled = false;
    }
}

async function saveEdit(root, id, body) {
    showSpinner(root);
    try {
        const fd = new FormData();
        fd.append('body', body);
        fd.append('_method', 'PATCH');
        const res = await fetch(`${root.dataset.base}/${id}`, { method: 'POST', headers: jsonHeaders(), body: fd });
        if (!res.ok) throw new Error(`Edit failed: ${res.status}`);
        await loadComments(root, { spinner: false });
    } catch (err) {
        console.error(err);
        await loadComments(root, { spinner: false });
    }
}

async function removeComment(root, id) {
    showSpinner(root);
    try {
        const res = await fetch(`${root.dataset.base}/${id}`, { method: 'DELETE', headers: jsonHeaders() });
        if (!res.ok) throw new Error(`Delete failed: ${res.status}`);
        await loadComments(root, { spinner: false });
    } catch (err) {
        console.error(err);
        await loadComments(root, { spinner: false });
    }
}

export function initComments() {
    const root = document.querySelector('[data-comments]');
    if (!root) return;

    loadComments(root);

    const form = root.querySelector('[data-comment-form]');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            submitNew(root, form);
        });
    }

    // Close any open owner menu when clicking elsewhere.
    document.addEventListener('click', () => {
        root.querySelectorAll('[data-menu]:not(.hidden)').forEach((m) => m.classList.add('hidden'));
    });
}
