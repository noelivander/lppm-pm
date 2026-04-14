document.addEventListener('alpine:init', () => {
    Alpine.data('heroSlider', () => ({
        activeSlide: 0,
        slides: [],

        init() {
            const rawSlides = window.heroSlides || []

            this.slides = rawSlides
                .filter(Boolean)
                .map(path => `/storage/${path}`)

            if (this.slides.length === 0) {
                console.warn('Hero slides kosong')
                return
            }

            setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length
            }, 5000)
        }
    }))
})
