import './bootstrap';
import Alpine from 'alpinejs';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

window.Quill = Quill;

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
});
