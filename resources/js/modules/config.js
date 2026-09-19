// Shared client config read from the layout's <head> meta tags and <body> data.
// Keeping this in one place means the rest of the JS never touches the DOM for config.

const meta = (name) => document.querySelector(`meta[name="${name}"]`)?.content ?? '';

export const csrfToken = () => meta('csrf-token');

export const loginUrl = () => meta('login-url') || '/login';
export const registerUrl = () => meta('register-url') || '/register';

/** Current authenticated user id, or null for guests. */
export function authId() {
    const raw = document.body.dataset.authId;
    return raw ? Number(raw) : null;
}

export const isAuthed = () => authId() !== null;

/** Default headers for JSON fetch requests that mutate state. */
export function jsonHeaders(extra = {}) {
    return {
        'X-CSRF-TOKEN': csrfToken(),
        'Accept': 'application/json',
        ...extra,
    };
}

/**
 * Normalise a stored media_uri into something the browser can load.
 * Absolute URLs pass through; root-relative and bare paths are used as-is
 * (the browser resolves them against the current origin).
 */
export function mediaUrl(uri) {
    if (!uri) return '';
    if (/^https?:\/\//i.test(uri)) return uri;
    return uri.startsWith('/') ? uri : `/${uri}`;
}
