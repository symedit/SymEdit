$(function(){
    $('form').submit(function(e){
        if($(this).data('submitted')){
            e.stopPropagation(); 
            e.preventDefault();
        } else {
            $(this).data('submitted', true); 
        }
        
        $(this).find('button, input[type=submit], a.btn').unbind('click').click(function(e){
            e.stopPropagation(); 
            e.preventDefault(); 
        }); 
    }); 
}); 