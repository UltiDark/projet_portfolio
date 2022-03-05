/**
 * Mise en place du parallax (toutes les pages)
 */


// Récupération de chaque plan du parallax
let stars = document.getElementById('stars');
let moon = document.getElementById('moon');
let mountains_behind = document.getElementById('mountains_behind');
let text = document.getElementById('text');
let btn = document.getElementById('btn');
let mountains_front = document.getElementById('mountains_front'); 
  
// Lorsque l'on fait un scroll vertical dans la page
window.addEventListener('scroll', function(){
    let value = window.scrollY; // Récupération la valeur du scroll

    // Variation l'emplacement de chaque plan + texte en fonction de la valeur du scroll
    stars.style.left = value *0.25 + 'px'; 
    moon.style.top = value *1.05 +'px';
    mountains_behind.style.top = value *0.5 + 'px';
    mountains_front.style.top = value *0 + 'px';
    text.style.marginBottom = value *5 + 'px';
    text.style.marginRight = value *1.5 + 'px';
    btn.style.marginTop = value *1.5 + 'px';
})