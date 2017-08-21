$(function(){
    $('.btn-signale-comment').click(function(){
        console.log($(this).parent().prev());
       $(this).parent().prev().addClass('signale');       
    });
});