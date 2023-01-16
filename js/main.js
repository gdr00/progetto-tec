var slideIndex = 1;
var theme = "dark";
var themeProperties = ['--bodybgcolor', '--navbarbg', '--txtcolor', '--linkcolor', '--linkvisited', '--linkhovercolor', '--navlinkcolor', '--navlinkvisited', '--navlinkhovercolor', '--navlinkbg', '--themebg', '--themeborder', '--iconpos', '--logo'];
var themeValues =    [['#050505', '#050505', '#f1f1f1', '#f1f1f1', '#f1f1f1', '#1BDC88', '#f1f1f1', '#f1f1f1', '#1BDC88', '#5050504d', '#f1f1f1', '#1BDC88', 'left', 'url(../img/logo-sfondo-nero.webp)'], 
                      ['#ffffff', '#ffffff', '#000000', '#000000', '#000000', '#1BDC88', '#000000', '#000000', '#1BDC88', '#ababab4d', '#000000', '#1BDC88', 'right', 'url(../img/logo-sfondo-bianco.webp)']];

document.readyState(setup());

function setup() {
  sessionStorage.setItem('panelTheme', theme);
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
  localstTheme = sessionStorage.getItem('panelTheme');
  if (localstTheme == 'dark') {
    setTheme('light');
  } else {
    setTheme('dark');
  }
}

function setTheme(theme) {
  if (theme == 'dark') {
    sessionStorage.setItem('panelTheme', theme);
    for (var i = 0; i < themeProperties.length; i++) {
      document.documentElement.style.setProperty(themeProperties[i], themeValues[0][i]);
    } /* attenzione alla posizione delle variabili globali, prima erano tra set theme e changeTheme, siccome change chiama set e le variabili erano dichiarate sotto change per change non esistevano ancora e crashava con metodo .lenght*/
  }
  if (theme == 'light') {
    sessionStorage.setItem('panelTheme', theme);
    for (var i = 0; i < themeProperties.length; i++) {
      document.documentElement.style.setProperty(themeProperties[i], themeValues[1][i]);
    }/**/
  }
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

function toggleMenu(){
  var menu = document.getElementById("menus");
  if(menu.style.display == "flex"){
    menu.style.display = "none";
  }else{
    menu.style.display = "flex";
  }
}