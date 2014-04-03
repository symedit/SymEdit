$(function(){
    window.setTimeout(function(){
        var $flash = $('#flash');
        $flash.find('.message').slideUp(400, function(){
            $(this).hide();
        });
    }, 5000);
});