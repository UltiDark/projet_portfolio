let textProjet =
[
    "Alors qu'un affrontement entre deux tribus fait rage. Les esprits protecteurs de chaque tribu décide de prendre part à la bataille. Dans ce jeu, chaque joueur contrôle deux avatars aux déplacements opposés sur l'axe horizontal. Pour ma part, j'ai principalement produit les assets 2D.Le jeu est développé sur Construct 2 avec la suite Adobe.",
    "Jouez à un flipper où presque aucun élément est visible. La particularité de ce projet est qu'il a été conçu et produit en une semaine. Pour ma part, j'ai produit tous les assets sonores et la documentation. Le jeu est développé sur Unity avec 3Ds Max, Fmod et la suite Adobe.,",
    "Contrôlez un personnage possédant un tentacule collant et manipulez tant bien que mal des objets du quotidien. Pour ma part, j'ai produit tous les assets 2D, une partie des assets 3D et la documentation. Le jeu est développé sur Unity avec 3Ds Max, Fmod et la suite Adobe.",
    "Les coureurs sont en place. La tension est à son comble... Et GO !!!! Lequel des cent coureurs va atteindre la ligne d'arrivée ? Attention, tous les coups sont permis.",
    "Match en un contre un dans au style pop art.",
    "Vous vous perdez en montagne, sans moyen de communiquer avec le monde extérieur et sans repère pour rentrer chez vous. Heureusement, vous trouvez un abri au loin pour passer la nuit et survivre... Mais pour combien de temps ?"
]

let titreProjet =
[
    "Mystic Mask",
    "Flipperino",
    "Tentacule",
    "Runner Royale",
    "Pop Art",
    "Un Jour de Plus",
]

$('.rea div div img').on('click',function(){
    $('.tempo').remove();

    for (i=0; i<textProjet.length; i++)
    {
        if($(this).attr('id') == i){
            $('.rea').css("flex-direction","column")
            $(this).parent().after('<div class="tempo"><h3>'+titreProjet[i]+'</h3><p>'+textProjet[i]+'</p></div>');
            return;
        }
    }
});