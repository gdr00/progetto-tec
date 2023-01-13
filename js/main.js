var slideIndex = 1;
var theme = "dark";

document.readyState(setup());

function setup() {
  localStorage.setItem('panelTheme', theme);
}


// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].classList.add("active");
}

function changeTheme() {
  localstTheme = localStorage.getItem('panelTheme');
  if (localstTheme == 'dark') {
    setTheme('light');
  } else {
    setTheme('dark');
  }
}

function setTheme(theme) {
  if (theme == 'dark') {
    localStorage.setItem('panelTheme', theme);
    document.documentElement.style.setProperty('--bodybgcolor', '#050505');
    document.documentElement.style.setProperty('--navbarbg', '#050505');
    document.documentElement.style.setProperty('--txtcolor', '#f1f1f1');
    document.documentElement.style.setProperty('--linkcolor', '#f1f1f1');
    document.documentElement.style.setProperty('--linkvisited', '#f1f1f1');
    document.documentElement.style.setProperty('--linknavhovercolor', '#1BDC88');
    document.documentElement.style.setProperty('--iconpos', 'left');
    document.documentElement.style.setProperty('--logo', 'url(../img/logo-sfondo-nero.webp)');
  }
  if (theme == 'light') {
    localStorage.setItem('panelTheme', theme);
    document.documentElement.style.setProperty('--bodybgcolor', '#ffffff');
    document.documentElement.style.setProperty('--navbarbg', '#ffffff');
    document.documentElement.style.setProperty('--txtcolor', '#000000');
    document.documentElement.style.setProperty('--linkcolor', '#000000');
    document.documentElement.style.setProperty('--linkvisited', '#000000');
    document.documentElement.style.setProperty('--linknavhovercolor', '#1BDC88');
    document.documentElement.style.setProperty('--iconpos', 'right');
    document.documentElement.style.setProperty('--logo', 'url(../img/logo-sfondo-bianco.webp)');
  }
}

var btn = $('#toTopBTN');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});