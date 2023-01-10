let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function iterateSlides(value_to_add) {
  showSlides(slideIndex += value_to_add);
}

// Thumbnail image controls
function currentSlide(slide_pos) {
  showSlides(slideIndex = slide_pos);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("slideshowImage");
  let dots = document.getElementsByClassName("slideshowDot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}