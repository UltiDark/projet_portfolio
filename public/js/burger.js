let menuOpen =false;

$('.menu-btn').on('click', function(){
    if(!menuOpen){
        $(this).addClass('open');
        $('.menu-mobile').show("slow").css('display', 'block');
        menuOpen = true;
    }
    else{
        $(this).removeClass('open');
        $('.sousMobile').css('display','none');
        $('.menuMobile>a').css('background-color','#562c61');
        $('.menu-mobile').hide(1000);
        menuOpen = false;
    }
});


function affichageSous(menuSous){
    let classSous = '.'
    classSous += menuSous;
    $('.sousMobile').css('display','none');
    $(classSous).css('display', 'inline');
}

$('.menuMobile>a').on('click', function(){
    $('.menuMobile>a').css('background-color','#562c61');
    $(this).css('background-color','#901AAD');

});