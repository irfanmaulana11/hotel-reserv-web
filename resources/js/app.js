import './bootstrap';

function initStayShowcase() {
    const root = document.getElementById('stay-showcase');
    if (!root) {
        return;
    }

    const viewport = root.querySelector('[data-showcase-viewport]');
    const track = root.querySelector('[data-showcase-track]');
    const slides = track ? [...track.querySelectorAll('[data-showcase-slide]')] : [];
    const prevBtn = root.querySelector('[data-showcase-prev]');
    const nextBtn = root.querySelector('[data-showcase-next]');
    const dotsContainer = root.querySelector('[data-showcase-dots]');

    if (!viewport || !track || slides.length === 0 || !prevBtn || !nextBtn || !dotsContainer) {
        return;
    }

    const gapPx = 16;
    let index = 0;
    /** @type {ReturnType<typeof setInterval> | null} */
    let autoplayId = null;

    const visibleCount = () => {
        const w = window.innerWidth;
        if (w >= 1024) {
            return Math.min(3, slides.length);
        }
        if (w >= 640) {
            return Math.min(2, slides.length);
        }

        return 1;
    };

    const maxIndex = () => Math.max(0, slides.length - visibleCount());

    const slideWidth = () => {
        const vc = visibleCount();
        const gaps = gapPx * Math.max(0, vc - 1);

        return (viewport.clientWidth - gaps) / vc;
    };

    const layoutSlides = () => {
        const w = slideWidth();
        slides.forEach((slide) => {
            slide.style.flex = `0 0 ${w}px`;
            slide.style.width = `${w}px`;
        });
    };

    const setTransform = () => {
        const w = slideWidth();
        const offset = index * (w + gapPx);
        track.style.transform = `translate3d(-${offset}px, 0, 0)`;
    };

    const renderDots = () => {
        const pages = maxIndex() + 1;
        dotsContainer.innerHTML = '';

        for (let i = 0; i < pages; i += 1) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('role', 'tab');
            dot.setAttribute('aria-selected', i === index ? 'true' : 'false');
            dot.setAttribute('aria-label', `Slide ${i + 1} dari ${pages}`);
            dot.className =
                i === index
                    ? 'h-2 w-2 rounded-full bg-brand transition-colors sm:h-2.5 sm:w-2.5'
                    : 'h-2 w-2 rounded-full bg-stone-300 transition-colors hover:bg-stone-400 sm:h-2.5 sm:w-2.5';
            dot.addEventListener('click', () => {
                index = i;
                sync();
                restartAutoplay();
            });
            dotsContainer.appendChild(dot);
        }
    };

    const sync = () => {
        index = Math.min(index, maxIndex());
        layoutSlides();
        setTransform();
        renderDots();
    };

    const goNext = () => {
        if (index >= maxIndex()) {
            index = 0;
        } else {
            index += 1;
        }
        sync();
    };

    const goPrev = () => {
        if (index <= 0) {
            index = maxIndex();
        } else {
            index -= 1;
        }
        sync();
    };

    const stopAutoplay = () => {
        if (autoplayId !== null) {
            clearInterval(autoplayId);
            autoplayId = null;
        }
    };

    const startAutoplay = () => {
        stopAutoplay();
        autoplayId = setInterval(goNext, 3000);
    };

    const restartAutoplay = () => {
        stopAutoplay();
        startAutoplay();
    };

    prevBtn.addEventListener('click', () => {
        goPrev();
        restartAutoplay();
    });

    nextBtn.addEventListener('click', () => {
        goNext();
        restartAutoplay();
    });

    root.addEventListener('mouseenter', stopAutoplay);
    root.addEventListener('mouseleave', startAutoplay);

    root.addEventListener('focusin', stopAutoplay);
    root.addEventListener('focusout', () => {
        if (!root.matches(':hover')) {
            startAutoplay();
        }
    });

    let resizeRaf = 0;
    window.addEventListener('resize', () => {
        cancelAnimationFrame(resizeRaf);
        resizeRaf = requestAnimationFrame(sync);
    });

    sync();
    startAutoplay();
}

document.addEventListener('DOMContentLoaded', initStayShowcase);
