// let textProjet =
// [
//     "Alors qu'un affrontement entre deux tribus fait rage. Les esprits protecteurs de chaque tribu décide de prendre part à la bataille. Dans ce jeu, chaque joueur contrôle deux avatars aux déplacements opposés sur l'axe horizontal. Pour ma part, j'ai principalement produit les assets 2D.Le jeu est développé sur Construct 2 avec la suite Adobe.",
//     "Jouez à un flipper où presque aucun élément est visible. La particularité de ce projet est qu'il a été conçu et produit en une semaine. Pour ma part, j'ai produit tous les assets sonores et la documentation. Le jeu est développé sur Unity avec 3Ds Max, Fmod et la suite Adobe.",
//     "Contrôlez un personnage possédant un tentacule collant et manipulez tant bien que mal des objets du quotidien. Pour ma part, j'ai produit tous les assets 2D, une partie des assets 3D et la documentation. Le jeu est développé sur Unity avec 3Ds Max, Fmod et la suite Adobe.",
//     "Les coureurs sont en place. La tension est à son comble... Et GO !!!! Lequel des cent coureurs va atteindre la ligne d'arrivée ? Attention, tous les coups sont permis.",
//     "Match en un contre un dans au style pop art.",
//     "Vous vous perdez en montagne, sans moyen de communiquer avec le monde extérieur et sans repère pour rentrer chez vous. Heureusement, vous trouvez un abri au loin pour passer la nuit et survivre... Mais pour combien de temps ?"
// ]
// 
// let titreProjet =
// [
//     "Mystic Mask",
//     "Flipperino",
//     "Tentacule",
//     "Runner Royale",
//     "Pop Art",
//     "Un Jour de Plus",
// ]

var lastWidth = $(window).width();
$('.tempo').hide();



$(document).ready(
    positionEnfant(),
    $('.tempo').hide()
    );
$(window).resize(function(){
    if($(window).width()!=lastWidth){
        positionEnfant();
        lastWidth = $(window).width();
       }
});

function positionEnfant() {
    var i=0;
    $(".rea div img").each(function() {
        let x = $(this).position().left;
        let y = $(this).position().top;
        let widthX = $('.rea div').css('width');
        let heightY= $('.rea div').css('height');
        $('#' + i).css({
            'left' : x,
            'top' : y,
            'width' : widthX,
            'height' : heightY,
        });
        i= i+1;
    });

}

$('.rea div img').mouseenter(function(){

    $('.tempo').show();

    $(this).css({'filter' :'blur(0.2em) grayscale(75%) brightness(50%)',});


    for (i=0; i<textProjet.length; i++)
    {
        if($(this).attr('id') == i)
        {
            //$(this).parent().after('<div class="tempo"><h3>'+titreProjet[i]+'</h3><p>'+textProjet[i]+'</p></div>');
            $('.tempo').css({
                'left' : x,
                'top' : y,
                'width' : widthX,
                'height' : heightY,});
            return;
        }
    }
});

$('.rea div img').mouseleave(function(){
    $(this).css('filter','blur(0em) grayscale(0%)');
    $('.tempo').hide();
});