/**
 * Affichage des boutons modification et suppression de l'admin (galerie.html.twig et projet.html.twig)
 * Affichage d'un effet de blur lorsque l'on survole une image (galerie.html.twig et projet.html.twig)
 * Affichage du l'extrait de texte lorsque l'on survole un projet (projet.html.twig)
 */


// Récupération de la largeur de la fenêtre
var lastWidth = $(window).width();

// Lorsque la page est chargée
$(document).ready(function(){
    positionEnfant() // Positionnement des enfants (bouton et extrait)
    $('.tempo').hide() // Désactivation de tous les extraits
});


// Lorsque la page change de taille
$(window).resize(function(){
    // On vérifie que le change de taille est bien sur la largeur
    if($(window).width()!=lastWidth){
        positionEnfant(); // Positionnement des enfants (bouton et extrait)
        lastWidth = $(window).width(); // Récupération de la nouvelle largeur
       }
});


// Fonction qui permet de récupérer la position l'image pour la donner aux enfants
function positionEnfant() {
    var i=0;
    var j=0;
    // Pour chaque image
    $(".rea div img").each(function() {
        // Récupération de la position de l'image
        let x = $(this).position().left;
        let y = $(this).position().top;

        // Récupération de la dimension de la div de l'image
        let widthX = $('.rea div').css('width');
        let heightY= $('.rea div').css('height');

        // Ajout de la position et des dimensions aux enfants
        $('#' + i).css({ // Enfant de l'image -> les boutons 
            'left' : x,
            'top' : y,
            'width' : widthX,
            'height' : heightY,
        });  
        $('#P' + j).css({ // Enfant de l'image -> l'extrait
            'left' : x,
            'top' : y,
            'width' : widthX,
            'height' : heightY,
        });
        i= i+1;
        j= j+1;
    });

}


// Si le pointeur entre en collision avec l'image
$('.rea div img').mouseenter(function(){

    var imgId = $(this).attr('id'); // Récupération de son id
    $('.tempo#P'+imgId).show(); // Activation de son extrait

    $(this).css({'filter' :'blur(0.2em) grayscale(75%) brightness(50%)'}); // Effet de blur

    $('.tempo#P'+imgId).css({
        'left' : $(this).position().left,
        'top' : $(this).position().top,
        'width' : $('.rea div').css('width'),
        'height' : $('.rea div').css('height'),
    });

});


// Si le pointeur n'est plus en collision avec l'image
$('.rea div img').mouseleave(function(){
    $(this).css('filter','blur(0em) grayscale(0%)'); // Désactivation de l'effet de blur
    $('.tempo').hide(); // Désactivation de tous les extraits
});