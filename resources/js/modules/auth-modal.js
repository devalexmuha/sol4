// A small, dependency-free modal shown when a guest tries to perform an
// action that requires authentication (liking, commenting, etc).

import { loginUrl, registerUrl } from './config.js';

let overlay = null;

function build() {
    if (overlay) return overlay;

    overlay = document.createElement('div');
    overlay.className =
        'fixed inset-0 z-[100] hidden items-center justify-center bg-sol-night/60 p-4 backdrop-blur-sm';
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');

    overlay.innerHTML = `
        <div class="relative w-full max-w-sm overflow-hidden rounded-sol bg-sol-panel shadow-sol-card">
            <span class="absolute right-4 top-4 border-l-2 border-sol-orange pl-3 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-mars">Sol 04</span>

            <div class="px-6 py-8 sm:px-8">
                <p class="font-body text-[10px] font-bold uppercase tracking-[0.22em] text-sol-mars">Access required</p>
                <h2 class="mt-3 font-display text-2xl font-bold text-sol-night" data-auth-modal-title>Sign in to continue</h2>
                <p class="mt-3 font-body text-sm leading-6 text-sol-muted" data-auth-modal-message>
                    You need to be signed in to interact with transmissions.
                </p>

                <div class="mt-7 flex flex-col gap-3">
                    <a href="${loginUrl()}" class="flex h-12 items-center justify-center border border-sol-mars bg-sol-mars font-body text-[11px] font-bold uppercase tracking-[0.18em] text-sol-panel transition hover:border-sol-orange hover:bg-sol-orange">Log in</a>
                    <a href="${registerUrl()}" class="flex h-12 items-center justify-center border border-sol-line bg-sol-paper font-body text-[11px] font-bold uppercase tracking-[0.18em] text-sol-mars transition hover:border-sol-orange">Register</a>
                </div>

                <button type="button" data-auth-modal-close class="mt-5 block w-full text-center font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted transition hover:text-sol-mars">Not now</button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    const close = () => closeAuthModal();
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay || e.target.closest('[data-auth-modal-close]')) close();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay && !overlay.classList.contains('hidden')) close();
    });

    return overlay;
}

export function openAuthModal(message) {
    const el = build();
    if (message) el.querySelector('[data-auth-modal-message]').textContent = message;
    el.classList.remove('hidden');
    el.classList.add('flex');
    document.body.classList.add('sol-no-scroll');
}

export function closeAuthModal() {
    if (!overlay) return;
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
    document.body.classList.remove('sol-no-scroll');
}
