$(function(){
    $('.tab-pane input, .tab-pane textarea').on('invalid', function(){
       var $closest = $(this).closest('.tab-pane'); 
       var id = $closest.attr('id'); 
       
       $('.nav-tabs a[href="#' + id + '"]').tab('show'); 
    });
}); 