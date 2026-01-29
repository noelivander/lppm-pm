new WOW().init();

function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const count = parseInt(counter.innerText);
        const increment = target / 100;

        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(() => animateCounters(), 20);
        } else {
            counter.innerText = target + '+';
        }
    });
}
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
          target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
          });
      }
  });
});


function initHeroSlider() {
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.hero-indicator');

    if (!slides.length) return;

    let activeIndex = 0;

    const setActive = (index) => {
        slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === index);
        });
        indicators.forEach((dot, i) => {
            dot.classList.toggle('is-active', i === index);
        });
        activeIndex = index;
    };

    indicators.forEach((dot, i) => {
        dot.addEventListener('click', (e) => {
            e.preventDefault();
            setActive(i);
        });
    });

    if (slides.length > 1) {
        setInterval(() => {
            const next = (activeIndex + 1) % slides.length;
            setActive(next);
        }, 5000);
    }
}

window.addEventListener('load', () => {
    setTimeout(animateCounters, 1000);
    initHeroSlider();
});
