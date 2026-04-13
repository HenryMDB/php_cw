document.addEventListener('DOMContentLoaded', () => {
    // 1. Navbar Glassmorphism Scroll
    const nav = document.querySelector('nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });
    }

    // 2. Scroll Animation Observer (Fade Up)
    const fadeElements = document.querySelectorAll('.scroll-animate');
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('scrolled-in');
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);

    fadeElements.forEach(el => scrollObserver.observe(el));

    // 3. Ripple Effect on Buttons
    const buttons = document.querySelectorAll('.btn, .btn-admin-edit, .btn-admin-delete');
    buttons.forEach(btn => {
        // Ensure parent is position relative and overflow hidden for ripple
        if(window.getComputedStyle(btn).position === 'static') {
            btn.style.position = 'relative';
        }
        btn.style.overflow = 'hidden';

        btn.addEventListener('mousedown', function (e) {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            let ripples = document.createElement('span');
            ripples.className = 'ripple-effect';
            ripples.style.left = x + 'px';
            ripples.style.top = y + 'px';
            this.appendChild(ripples);

            setTimeout(() => {
                ripples.remove();
            }, 600); // Remove after animation ends
        });
    });

    // 4. Smooth Page Transitions
    const pageOverlay = document.querySelector('.page-transition-overlay');
    
    // Auto remove the loading screen when page paints
    if (pageOverlay) {
        setTimeout(() => {
            pageOverlay.classList.add('page-loaded');
        }, 100); // small delay to ensure DOM is ready
    }
    
    // Intercept link clicks to trigger fade out before navigating
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetAttr = this.getAttribute('target');
            const href = this.getAttribute('href');
            
            // Filter out empty, anchor links, external links, mailto and delete actions
            if (!href || 
                targetAttr === '_blank' || 
                href.startsWith('#') || 
                href.startsWith('javascript') || 
                href.startsWith('http') || 
                href.startsWith('mailto:') ||
                this.classList.contains('btn-admin-delete')) {
                return;
            }

            e.preventDefault();
            
            if (pageOverlay) {
                // Fade out triggered by removing 'page-loaded' class
                pageOverlay.classList.remove('page-loaded'); 
                setTimeout(() => {
                    window.location.href = href;
                }, 300); // must align with CSS transition time
            } else {
                window.location.href = href;
            }
        });
    });

    // 5. Cinematic Rain Effect for Header
    const canvas = document.getElementById('rainCanvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        
        let width = canvas.width = canvas.offsetWidth;
        let height = canvas.height = canvas.offsetHeight;

        const columns = Math.floor(width / 3);
        const drops = [];
        for(let i = 0; i < columns; i++) {
            drops[i] = Math.random() * -100;
        }

        function drawRain() {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.15)';
            ctx.fillRect(0, 0, width, height);

            ctx.fillStyle = 'rgba(245, 197, 24, 0.6)'; // Cinematic yellow rain drops
            
            for(let i = 0; i < drops.length; i++) {
                const x = i * 3;
                const y = drops[i];

                ctx.fillRect(x, y, 1, 10 + Math.random() * 5);

                if(y > height && Math.random() > 0.95) {
                    drops[i] = 0;
                }

                drops[i] += 10 + Math.random() * 10;
            }
        }
        setInterval(drawRain, 30);

        window.addEventListener('resize', () => {
            width = canvas.width = canvas.offsetWidth;
            height = canvas.height = canvas.offsetHeight;
        });
    }
});
