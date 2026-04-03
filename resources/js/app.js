import './bootstrap';
import Alpine from 'alpinejs';
import Quill from 'quill';
import Table from 'quill/modules/table';
import 'quill/dist/quill.snow.css';

Quill.register({ 'modules/table': Table }, true);

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
                table: true,
                toolbar: {
                    container: [
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link'],
                        [{ 'table': 'insert-table' }],
                        ['clean']
                    ],
                    handlers: {
                        table: function () {
                            quill.getModule('table').insertTable(2, 3);
                        }
                    }
                }
            }
        });

        const textarea = document.getElementById('description');
        if (textarea.value) quill.root.innerHTML = textarea.value;

        // Sync to hidden textarea on every change so native form submit always has content
        quill.on('text-change', () => {
            textarea.value = quill.getText().trim() ? quill.root.innerHTML : '';
        });
    }
});
