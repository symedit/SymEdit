$(function(){
    var $elms = $('[data-toggle="form-forward"]'); 
    
    $elms.click(function(){
       $this = $(this); 
       
       if($this.data('message')){
           if(!confirm($this.data('message'))){
               return; 
           }
       } 
       
        $($this.data('target')).submit(); 
    });
});