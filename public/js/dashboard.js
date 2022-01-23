$('.dashboardMenu ul li').on('click',function(){
    console.log('coucou');
    let $infoVisible = $(this).attr('id') + 'Info';
    $(".dashboardSection").hide(1000)
    $("section#"+$infoVisible).show("slow").css("display","block")
})