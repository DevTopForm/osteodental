document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.js-image-wrapper input[type="file"]');

    if (inputs && inputs.length) {
        inputs.forEach((input) => {
            // Use capturing listener to intercept before other handlers
            input.addEventListener('change', function (e) {
                const files = this.files ? Array.from(this.files) : [];
                const hasAvif = files.some(f => (f.type && f.type.toLowerCase() === 'image/avif') || (/\.avif$/i.test(f.name)));

                // Fallback: also check by input value extension (older browsers)
                const val = (this.value || '').toLowerCase();
                const byExt = val.endsWith('.avif');

                if (hasAvif || byExt) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    alert('Формат avif запрещён к загрузке');
                    // Clear the input
                    try {
                        this.value = '';
                    } catch (_) {
                    }
                }
            }, true); // capture phase
        });
    }
});