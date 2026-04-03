import './bootstrap';
import Alpine from 'alpinejs';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Make Alpine available globally
window.Alpine = Alpine;

// Start Alpine
Alpine.start();

// Scroll fade-in
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Quill rich text editor (admin product create/edit)
    const editorEl = document.getElementById('description-editor');
    if (editorEl) {
        const quill = new Quill(editorEl, {
            theme: 'snow',
            placeholder: 'Write product description...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        const textarea = document.getElementById('description');
        if (textarea.value) quill.root.innerHTML = textarea.value;

        const form = editorEl.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                textarea.value = quill.root.innerHTML;
            });
        }
    }
});
