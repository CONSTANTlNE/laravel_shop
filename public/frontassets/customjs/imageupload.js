// Existing create modal setup (kept for backward compatibility)
(function () {
    const input = document.getElementById('fileInput');
    const preview = document.getElementById('preview');
    if (!input || !preview) return;
    let filesArray = [];

    input.addEventListener('change', () => {
        for (const file of input.files) filesArray.push(file);
        input.value = '';
        render();
    });

    preview.addEventListener('click', (e) => {
        const btn = e.target.closest ? e.target.closest('.remove-btn') : null;
        if (!btn) return;
        const index = Number(btn.getAttribute('data-index'));
        if (!Number.isNaN(index)) {
            filesArray.splice(index, 1);
            render();
        }
    });

    function render() {
        preview.innerHTML = '';
        preview.classList.toggle('preview-single', filesArray.length === 1);
        filesArray.forEach((file, index) => {
            const item = document.createElement('div');
            item.className = 'preview-item';
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    const img = document.createElement('img');
                    img.className = 'preview-img';
                    img.src = reader.result;
                    img.alt = file.name || 'preview image';
                    item.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                const box = document.createElement('div');
                box.className = 'preview-file';
                box.textContent = file.name;
                item.appendChild(box);
            }
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-btn';
            btn.setAttribute('data-index', String(index));
            btn.innerHTML = '&times;';
            item.appendChild(btn);
            preview.appendChild(item);
        });
        const dt = new DataTransfer();
        filesArray.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }
})();

// Reusable setup for edit modals (and any other file input + preview pair)
// Existing create modal setup (kept for backward compatibility)
(function () {
    const input = document.getElementById('fileInput');
    const preview = document.getElementById('preview');
    if (!input || !preview) return;
    let filesArray = [];

    input.addEventListener('change', () => {
        for (const file of input.files) filesArray.push(file);
        input.value = '';
        render();
    });

    preview.addEventListener('click', (e) => {
        const btn = e.target.closest ? e.target.closest('.remove-btn') : null;
        if (!btn) return;
        const index = Number(btn.getAttribute('data-index'));
        if (!Number.isNaN(index)) {
            filesArray.splice(index, 1);
            render();
        }
    });

    function render() {
        preview.innerHTML = '';
        preview.classList.toggle('preview-single', filesArray.length === 1);
        filesArray.forEach((file, index) => {
            const item = document.createElement('div');
            item.className = 'preview-item';
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    const img = document.createElement('img');
                    img.className = 'preview-img';
                    img.src = reader.result;
                    img.alt = file.name || 'preview image';
                    item.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                const box = document.createElement('div');
                box.className = 'preview-file';
                box.textContent = file.name;
                item.appendChild(box);
            }
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-btn';
            btn.setAttribute('data-index', String(index));
            btn.innerHTML = '&times;';
            item.appendChild(btn);
            preview.appendChild(item);
        });
        const dt = new DataTransfer();
        filesArray.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }
})();

// Reusable setup for edit modals (and any other file input + preview pair)
function setupPreview(inputEl, previewEl) {
    if (!inputEl || !previewEl) return;
    let filesArray = [];
    inputEl.addEventListener('change', () => {
        filesArray = Array.from(inputEl.files);
        render();
    });
    previewEl.addEventListener('click', (e) => {
        const btn = e.target.closest ? e.target.closest('.remove-btn') : null;
        if (!btn) return;
        const index = Number(btn.getAttribute('data-index'));
        if (!Number.isNaN(index)) {
            filesArray.splice(index, 1);
            render();
        }
    });

    function render() {
        previewEl.innerHTML = '';
        previewEl.classList.toggle('preview-single', filesArray.length === 1);
        filesArray.forEach((file, index) => {
            const item = document.createElement('div');
            item.className = 'preview-item';
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    const img = document.createElement('img');
                    img.className = 'preview-img';
                    img.src = reader.result;
                    img.alt = file.name || 'preview image';
                    item.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                const box = document.createElement('div');
                box.className = 'preview-file';
                box.textContent = file.name;
                item.appendChild(box);
            }
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-btn';
            btn.setAttribute('data-index', String(index));
            btn.innerHTML = '&times;';
            item.appendChild(btn);
            previewEl.appendChild(item);
        });
        const dt = new DataTransfer();
        filesArray.forEach(f => dt.items.add(f));
        inputEl.files = dt.files;
    }
}


// Initialize for all edit inputs (id starts with fileInputEdit_)
document.querySelectorAll('input[id^="fileInputEdit_"]').forEach((inputEl) => {
    const container = inputEl.closest('label') ? inputEl.closest('label').parentElement : inputEl.parentElement;
    const previewEl = container ? container.querySelector('.preview') : null;
    setupPreview(inputEl, previewEl);
});

document.querySelectorAll('input[id^="fileInput_products"]').forEach((inputEl) => {
    const container = inputEl.closest('label') ? inputEl.closest('label').parentElement : inputEl.parentElement;
    const previewEl = container ? container.querySelector('.preview') : null;
    setupPreview(inputEl, previewEl);
});







