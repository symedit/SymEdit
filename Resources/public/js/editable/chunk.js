 
 /**
  * Image Chunk 
  */
 _editable.registerInit('chunk.image', function(){
    var $form = this.find('input[type=file]').hide();
    this.find('img').click(function(){
        $form.trigger('click'); 
    }); 
 });
 
_editable.registerCallback('chunk.image', function(data){
    this.find('img').attr('src', data.src); 
}); 
