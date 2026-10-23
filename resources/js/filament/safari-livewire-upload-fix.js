/**
 * WebKit 26.5 drops multipart request bodies containing disk-backed Files.
 * See https://bugs.webkit.org/show_bug.cgi?id=319985.
 *
 * Slicing the File makes WebKit use its blob upload path. Reconstructing a
 * File can retain the original disk-backed handle, so it does not reliably
 * avoid the WebKit failure. This remains limited to Livewire's temporary
 * upload endpoint and WebKit.
 */
(() => {
    const isWebKit = /AppleWebKit/i.test(navigator.userAgent)
        && !/(Chrome|Chromium|CriOS|Edg)/i.test(navigator.userAgent);

    if (!isWebKit || window.__maracujaSafariLivewireUploadFixInstalled) {
        return;
    }

    window.__maracujaSafariLivewireUploadFixInstalled = true;

    const open = XMLHttpRequest.prototype.open;
    const send = XMLHttpRequest.prototype.send;

    XMLHttpRequest.prototype.open = function (method, url, ...arguments_) {
        this.__maracujaRequestUrl = String(url);

        return open.call(this, method, url, ...arguments_);
    };

    XMLHttpRequest.prototype.send = function (body) {
        if (
            !this.__maracujaRequestUrl?.includes('/livewire/upload-file')
            || !(body instanceof FormData)
        ) {
            return send.call(this, body);
        }

        const uploadBody = new FormData();

        body.forEach((value, key) => {
            if (value instanceof File) {
                const file = value.slice(0, value.size, value.type);

                uploadBody.append(key, file, value.name);

                return;
            }

            uploadBody.append(key, value);
        });

        return send.call(this, uploadBody);
    };
})();
