/**
 * Affichage du pop-up lorsque je clique sur une image de mes galérie 2D/3D (galerie.html.twig)
 * Sert aussi pour l'affichage du pop-up du nombre de catégorie pour un domaine (home.html.twig)
 */

// Lorsque la page est chargée
$(document).ready(function(){
    // Si on clique sur une image ou sur le bouton d'ajout d'un domaine
    $('.galerie, .addDomaine').on('click', function(){
        $("#myModal").show("fold"); // Le pop-up apparait
        $("body").addClass("stopScroll"); // On ne peut plus scroller

        // Uniquement pour les images
        $("#selectedImg").attr('src',$(this).attr("src")); // On affiche l'image dans le pop-up
        $("#commentaire_image").attr('value',$(this).attr("src")); // On ajoute dans le commentaire la source de l'image
    })
        

    //Si on clique sur la croix en haut à droite
    $(".close").on('click', function() { 
        $("#myModal").hide("fold"); // Le pop-up s'efface
        $("body").removeClass("stopScroll"); // On peut à nouveau scroller
    })
    
})
