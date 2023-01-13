var slideIndex = 1;

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

var theme = "dark";
document.localStorage.setItem('panelTheme', theme);

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
    $(':root').css('--bodybgcolor', '#050505');
  }
  if (theme == 'light') {
    localStorage.setItem('panelTheme', 'light');
    $(':root').css('--bodybgcolor', '#ffffff');
    alert("light");
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