/**
 * Affichage du contenu du menu burger (toutes les pages)
*/

// Assurance que le menu est fermé
let menuOpen =false;

// Si on clique sur le bouton du menu burgeur
$('.menu-btn').on('click', function(){
    // Si le menu est fermé
    if(!menuOpen){
        $(this).addClass('open'); // On déroule le menu
        $('.menu-mobile').show("slow").css('display', 'block'); //
        menuOpen = true; // Informe que le menu est ouvert
    }
    // Si le menu est ouvert
    else{
        $(this).removeClass('open'); // On 

        // Désactivation du menu et des sous-menus
        $('.sousMobile').css('display','none');
        $('.menu-mobile').hide(1000);

        menuOpen = false; // Informe que le menu est fermé
    }
});

// Affichage des sous-menus
function affichageSous(menuSous){
    // Concaténation pour utiliser la classe
    let classSous = '.'
    classSous += menuSous;

    $('.sousMobile').css('display','none'); // Désactivation de tous les sous-menus
    $(classSous).css('display', 'inline'); // Activation du sous-menu selectionné
}
