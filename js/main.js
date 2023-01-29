var slideIndex = 1;
var cardIndex = 1;
var translateAmount = 0;

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

/*document.scroll(function(){
  var y = this.scrollTop();
  window.alert(y);
  if(y > 200){
    document.getElementById("toTop").style.display = "block";
  }else{
    document.getElementById("toTop").style.display = "none";
  }
}); /*non va boh*/

function toTop(){
  window.scroll({top : 0, behavior : 'smooth'});
}

/* toTop appare solo se scrollo */
document.addEventListener("scroll", function() {
  var btn = document.getElementById("toTop");
  if (window.scrollY != 0) {
    btn.style.display = "block";
  } else {
    btn.style.display = "none";
  }
})

/* toTop scompare prima della stampa */
window.addEventListener("beforeprint", function (event) {
  var btn = document.getElementById("toTop");
  console.log("beforeprint");
  btn.style.display = "none";
});

/* sistema l'hamburgher che si apre/chiude/fa scomparire il menu */
window.onresize = function() {
  width = window.innerWidth;
  if (width <= 600 && document.getElementById("menus").style.display == "flex") {
    toggleMenu();
  }
  if (width > 600 && document.getElementById("menus").style.display == "none") {
    toggleMenu();
  }
}

function toggleMenu(){ /*for hamburger menu*/
  var menu = document.getElementById("menus");
  var hamburger = document.getElementById("hamburger");
  if(menu.style.display == "flex"){
    menu.style.display = "none";
    hamburger.setAttribute("aria-expanded", "false");
  }else{
    menu.style.display = "flex";
    hamburger.setAttribute("aria-expanded", "true");
  }
}

document.onclick = function (event) {
  var menu = document.getElementById("menus");
  var hamburger = document.getElementById("hamburger");
  if (event.target != menu && event.target != hamburger) {
    if (menu.style.display == "flex") {
      menu.style.display = "none";
      hamburger.setAttribute("aria-expanded", "false");
    }
  }
}/*lo avevo tolto perchè quando zoommi indietro il menù normale non si vede*/

function showCards(n){
  var cards = document.getElementsByClassName("partnerCard");
  cardIndex += n;
  if(cardIndex > cards.length){
    cardIndex = 1;
    translateAmount = 0;
    for (var i = 0; i < cards.length; i++){
      cards[i].style.transform = "translate(0px)";
    }
  } else if(cardIndex < 1){
    cardIndex = cards.length;
    translateAmount = (cards.length - 1) * 390;
    for (var i = 0; i < cards.length; i++){
      cards[i].style.transform = "translate(-" + translateAmount + "px)";
    }
  } else {
    translateAmount += n*390;
    for (var i = 0; i < cards.length; i++) {
      cards[i].style.transform = "translate(-"+translateAmount+"px)";
    }
  }
}

//--------------------------------------------------------------

function setTheme(themeName) {
  sessionStorage.setItem('theme', themeName);
  document.documentElement.className = themeName;
}

// function to toggle between light and dark theme
function changeTheme() {
  if (sessionStorage.getItem('theme') == 'theme-dark') {
      setTheme('theme-light');
  } else { /*anche se non c'è il sessionStorage*/
      setTheme('theme-dark');
  }
}

function syncTheme() {
  if(sessionStorage.getItem('theme') == 'theme-light') {
    document.getElementById('themeButton').checked = true;
  }
}

// Immediately invoked function to set the theme on initial load
(function () {
  if (sessionStorage.getItem('theme') == 'theme-light') {
      setTheme('theme-light');
  } else {
      setTheme('theme-dark');
  }
})();

function changeForm (btnId) {
  document.getElementById("reset").click();
  var btn = document.getElementById(btnId);
  document.getElementById(btnId).classList.add("active");
  if (btn != document.getElementById("insBtn")) {
    document.getElementById("insBtn").classList.remove("active");
  }
  if (btn != document.getElementById("modBtn")) {
    document.getElementById("modBtn").classList.remove("active");
  }
  if (btn != document.getElementById("delBtn")) {
    document.getElementById("delBtn").classList.remove("active");
  }

  let operationBtn = document.getElementById("operationBtn");

  if (btnId == "insBtn") {
    document.getElementById("modAndDelInputs").style.display = "none";
    document.getElementById("insInputs").style.display = "block";
    operationBtn.name = "inserisci";
    operationBtn.value = "Inserisci";
  } 
  else if (btnId == "modBtn") {
      document.getElementById("insInputs").style.display = "none";
      document.getElementById("modAndDelInputs").style.display = "block";
      operationBtn.name = "modifica";
      operationBtn.value = "Modifica";
  } 
  else {
      document.getElementById("insInputs").style.display = "none";
      document.getElementById("modAndDelInputs").style.display = "block";
      operationBtn.name = "elimina";
      operationBtn.value = "Elimina";
  }
}