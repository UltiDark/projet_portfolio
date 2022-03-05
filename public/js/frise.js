/**
 * Affichage du contenu complémentaire de la frise (home.html.twig) 
*/

// Si on clique sur l'un des éléments de la frise
$('ol a div').on('click',function(){
    let $infoVisible = $(this).attr('id') + 'Info'; // Récupération de son id en ajoutant Info pour avoir l'id du contenu lié à l'élément de la frise
    $("aside").hide(1000) // Désactivation de tous les contenus complémentaires
    $("aside#"+$infoVisible).show("slow").css("display","flex") // Activation du contenu selectionné
})