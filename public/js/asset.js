$(document).ready(function(){
    $('.galerie, .addDomaine').on('click', function(){
        $("#myModal").show("fold");
        $("#selectedImg").attr('src',$(this).attr("src"));
        $("#commentaire_image").attr('value',$(this).attr("src"));
        $("body").addClass("stopScroll");
    })
    
    var span = document.getElementsByClassName("close")[0];
    
    $(".close").on('click', function() { 
        $("#myModal").hide("fold");
        $("body").removeClass("stopScroll");
    })
    
})
