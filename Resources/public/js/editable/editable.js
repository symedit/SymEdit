
var _editable = (function($){
    
    var $toolbar; 
    var $updatable; 
    var $update; 
    var initClosures = []; 
    var callbackClosures = []; 
    var dirty = []; 
    var started = false; 
    var fid = 0; 
    
    var init = function(){
        if(started){
            return; 
        } else {
            started = true; 
        }
        
        $toolbar = $('#symedit-toolbar'); 
        $update = $('<button type="button" class="btn btn-success pull-right">Save Changes</button>').click(update); 
        $toolbar.append($update); 
        
        $body = $('body'); 
        $body.css('paddingBottom', parseInt($body.css('paddingBottom'),10)+$toolbar.height()); 

        $updatable = $('*[data-update]');

        $updatable.each(function(){
            var $this = $(this); 
            var $form = $(this).closest('form'); 
            $this.on($this.data('update'), function(){
               changed($form); 
            });
            
            var editable = $form.data('editable') || null; 
            
            if(editable && initClosures[editable]){
                $.proxy(initClosures[editable], $form)(); 
            }
        }); 

        var $wysiwyg = $('.redactor'); 
                
        if($wysiwyg.size() > 0 ){
                $wysiwyg.redactor({ 
                air:true, 
                convertDivs: false,
                imageGetJson: imageGetJson, 
                airButtons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'fontcolor', 'backcolor', '|', 'image'], 
                // Force the update on the related textarea so it listens for events
                keyupCallback: function(obj){
                    obj.$el.change(); 
                }
            });   
        }
    }


    var changed = function($form){ 
        
        if(!$form.attr('id')){
            $form.attr('id', 'symedit-form-' + fid++);         
        }
    
        var id = $form.attr('id'); 
        
        if(!dirty[id]){
            dirty[id] = true; 
            $toolbar.show(); 
        }
    }

    var update = function(){
        for(id in dirty){
            submit(id); 
        }
    }

    var submit = function(id){
        var $form = $('#'+id); 
        
        $form.ajaxSubmit($.proxy(function(data){
            
            var editable = this.$form.data('editable') || null; 
            
            if(editable && callbackClosures[editable]){
                $.proxy(callbackClosures[editable], this.$form)(data); 
            }
            
            delete dirty[this.id]; 
            if(dirty.length === 0){
                $toolbar.fadeOut(); 
            }
        }, { id: id, $form: $form })); 
    }
    
    var registerInit = function(name, fn){
        initClosures[name] = fn; 
    }
    
    var registerCallback = function(name, fn){
        callbackClosures[name] = fn; 
    }

    return {
        init: init, 
        registerInit: registerInit, 
        registerCallback: registerCallback, 
    };
    
})(jQuery); 



$(function(){
    _editable.init(); 
});