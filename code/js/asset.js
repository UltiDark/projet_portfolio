$(document).ready(function(){
    $('img').on('click', function(){
        $("#myModal").show("fold");
        $("#selectedImg").attr('src',$(this).attr("src"));
        $("body").addClass("stopScroll");
    })
    
    var span = document.getElementsByClassName("close")[0];
    
    $(".close").on('click', function() { 
        $("#myModal").hide("fold");
        $("body").removeClass("stopScroll");
    })
    
})
