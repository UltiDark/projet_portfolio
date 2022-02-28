var lastWidth = $(window).width();
$('.tempo').hide();

$(document).ready(function(){
    positionEnfant()
    $('.tempo').hide()
});

$(window).resize(function(){
    if($(window).width()!=lastWidth){
        positionEnfant();
        lastWidth = $(window).width();
       }
});

function positionEnfant() {
    var i=0;
    var j=0;
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
        $('#P' + j).css({
            'left' : x,
            'top' : y,
            'width' : widthX,
            'height' : heightY,
        });
        i= i+1;
        j= j+1;
    });

}

$('.rea div img').mouseenter(function(){

    var imgId = $(this).attr('id');
    console.log(imgId);
    $('.tempo#P'+imgId).show();

    $(this).css({'filter' :'blur(0.2em) grayscale(75%) brightness(50%)'});

    $('.tempo#P'+imgId).css({
        'left' : $(this).position().left,
        'top' : $(this).position().top,
        'width' : $('.rea div').css('width'),
        'height' : $('.rea div').css('height'),
    });

});

$('.rea div img').mouseleave(function(){
    $(this).css('filter','blur(0em) grayscale(0%)');
    $('.tempo').hide();
});