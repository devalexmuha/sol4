// Instant client-side preview for any file input.
//
// Markup contract on the <input type="file">:
//   data-image-preview                    -> opt into previewing
//   data-preview-target="#css-selector"   -> element that shows the preview
//   data-preview-img-class="..."          -> classes for the injected <img>
//                                            (used when the target has no <img> yet)
//   data-preview-filename="#css-selector" -> optional element to show the file name
//
// The target may already contain an <img> (its src is swapped) or be a
// placeholder container (an <img> is created inside it).

let activeUrls = [];

function revokeAll() {
    activeUrls.forEach((u) => URL.revokeObjectURL(u));
    activeUrls = [];
}

function handleChange(input) {
    const file = input.files && input.files[0];
    const target = document.querySelector(input.dataset.previewTarget || '');
    if (!target) return;

    const nameEl = input.dataset.previewFilename
        ? document.querySelector(input.dataset.previewFilename)
        : null;

    if (!file || !file.type.startsWith('image/')) {
        if (nameEl) nameEl.textContent = '';
        return;
    }

    revokeAll();
    const url = URL.createObjectURL(file);
    activeUrls.push(url);

    let img = target.matches('img') ? target : target.querySelector('img[data-preview-img]');

    if (!img) {
        img = document.createElement('img');
        img.setAttribute('data-preview-img', '');
        img.alt = 'Selected image preview';
        if (input.dataset.previewImgClass) img.className = input.dataset.previewImgClass;
        target.replaceChildren(img);
    }

    img.src = url;
    if (nameEl) nameEl.textContent = file.name;
}

export function initImagePreview() {
    document.querySelectorAll('input[type="file"][data-image-preview]').forEach((input) => {
        input.addEventListener('change', () => handleChange(input));
    });
}
