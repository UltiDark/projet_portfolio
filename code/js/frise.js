$('ol a div').on('click',function(){
    let $infoVisible = $(this).attr('id') + 'Info';
    $("aside").hide(1000)
    $("aside#"+$infoVisible).show("slow").css("display","flex")
})