$(function(){
    
    var $holders = $('.layout-holder'); 
    var $containers = $holders.find('.layout-container'); 
    
    // Init Popovers
    $containers.popover({
        placement: 'top', 
        trigger: 'hover'
    }); 
    
    // Set classes / update hidden field on clicks
    $containers.click(function(){
        
        // Get holder
        var $holder = $(this).closest('.layout-holder'); 
        
        // Remove active classes
        $holder.find('.layout-container').removeClass('active'); 
        
        // Activate clicked
        $(this).addClass('active'); 
        
        // Update hidden field
        $holder.find('[data-toggle="template-target"]').val($(this).data('template-name')); 
    }); 
}); 