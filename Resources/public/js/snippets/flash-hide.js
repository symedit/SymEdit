$(function(){
    window.setTimeout(function(){
        var $flash = $('#flash'); 
        $flash.find('.message').slideUp(400, function(){
            $flash.hide(); 
        }); 
    }, 5000); 
}); 