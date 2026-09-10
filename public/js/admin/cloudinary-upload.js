window.cloudinaryUploadComponent = (config) => ({
    value: config.state,
    uploading: false,
    progress: 0,
    error: null,

    get preview() {
        const v = this.value;
        if (!v) return null;
        if (/^(https?:|data:|blob:|\\/\\/)/i.test(v)) return v;
        return config.base.replace(/\/+$/, '') + '/' + v.replace(/^\/+/, '');
    },

    pickFile(event) {
        const [file] = event.target.files || [];
        if (!file) return;
        this.upload(file);
        event.target.value = '';
    },

    upload(file) {
        const fd = new FormData();
        fd.append('file', file);
        fd.append('folder', config.folder);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', config.uploadUrl);
        xhr.setRequestHeader('X-CSRF-TOKEN', config.csrf);
        xhr.setRequestHeader('Accept', 'application/json');

        this.uploading = true;
        this.progress = 0;
        this.error = null;

        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) this.progress = Math.round((e.loaded / e.total) * 100);
        };

        xhr.onload = () => {
            this.uploading = false;
            let data = null;
            try {
                data = JSON.parse(xhr.responseText || 'null');
            } catch (_) {}

            if (xhr.status >= 200 && xhr.status < 300 && data && data.url) {
                this.progress = 100;
                this.value = data.url;
                if (config.publicIdState && data.public_id) config.publicIdState = data.public_id;
            } else {
                this.progress = 0;
                this.error = data && data.message
                    ? data.message
                    : 'L\'envoi a échoué (' + String(xhr.status) + ')';
            }
        };

        xhr.onerror = () => {
            this.uploading = false;
            this.progress = 0;
            this.error = 'Erreur réseau pendant l\'envoi';
        };

        xhr.send(fd);
    },

    remove() {
        this.value = null;
        if (config.publicIdState) config.publicIdState = null;
    },
});