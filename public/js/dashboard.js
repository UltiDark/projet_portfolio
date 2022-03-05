/**
 * Affichage des tableaux du dashboard (dashboard.html.twig)
*/

// Si on clique sur l'un des boutons
$('.dashboardMenu ul li').on('click',function(){
    let $infoVisible = $(this).attr('id') + 'Info'; // Récupération son id en ajoutant Info pour avoir l'id du tableau lié au bouton
    $(".dashboardSection").hide(1000) // Désactivation de tous les tableaux
    $("section#"+$infoVisible).show("slow").css("display","block") // Activation du tableau selectionné
})