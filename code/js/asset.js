$(document).ready(function(){
    $('img').on('click', function(){
        $("#myModal").show("fold");
        $("#img01").attr('src',$(this).attr("src"));
    })
    
    var span = document.getElementsByClassName("close")[0];
    
    $(".close").on('click', function() { 
        console.log("close");
        $("#myModal").hide("fold");
    })
    
})
