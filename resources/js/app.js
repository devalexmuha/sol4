import { initSubscribe } from './modules/subscribe.js';
import { initImagePreview } from './modules/image-preview.js';
import { initLikes } from './modules/likes.js';
import { initComments } from './modules/comments.js';

function boot() {
    initSubscribe();     // profile subscribe button
    initImagePreview();  // instant file-input previews (create post, edit profile)
    initLikes();         // like/unlike anywhere (delegated) + guest auth modal
    initComments();      // client-rendered comments on a single post view
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
