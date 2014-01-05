
$(function(){
    
    function setValue($obj){
        var len = $obj.val().length; 
        var max = $obj.data('max'); 
        $obj.data('counter').text(len+'/'+max);
        
        if(len > max){
            $obj.data('counter').addClass('over'); 
        } else if ($obj.data('counter').hasClass('over')){
            $obj.data('counter').removeClass('over'); 
        }
    }
    
    $('[data-toggle="char-count"]').each(function(){
        $this = $(this); 
        
        $counter = $('<span class="counter"></span>'); 
        $this.after($counter);
        $this.data('counter', $counter); 
        
        if(!$this.hasClass('counted')){
            $this.addClass('counted'); 
        }
        
        $this.keyup(function(){
            setValue($(this)); 
        }); 
        
        setValue($this); 
    }); 
    
}); 