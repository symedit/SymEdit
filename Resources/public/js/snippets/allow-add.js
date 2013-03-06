$(function(){
    var $elms = $('[data-toggle="allow-add"]'); 
    
    $elms.each(function(){
        $this = $(this); 
        
        var $target = $($this.data('target'));
        var count   = $this.data('count') || 0; 
        
        $this.click(function(){
            var proto = $target.data('prototype'); 
            $target.append('<div class="collection-item">'+proto.replace(/__name__/g, count)+'</div>');
            count++; 
        }); 
    });

});