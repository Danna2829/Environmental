
const btns = document.querySelectorAll('.nav-btn');
const slides = document.querySelectorAll('.video-slide');


/*inicio slider background de videos y btns de cambio*/
var sliderNav = function(manual){
    btns.forEach((btn) => {
        btn.classList.remove('active');
    });

    slides.forEach((slide) => {
        slide.classList.remove('active');
    });

    btns[manual].classList.add('active');
    slides[manual].classList.add('active');
}

btns.forEach((btn, i) => {
    btn.addEventListener('click', () => {
        sliderNav(i);
    });
});


