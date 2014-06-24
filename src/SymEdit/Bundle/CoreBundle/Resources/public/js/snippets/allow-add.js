$(function(){
    var $elms = $('[data-toggle="allow-add"]');

    $elms.each(function(){
        $this = $(this);

        var $target = $($this.data('target'));
        var count   = $this.data('count') || false;

        if (!count) {
            count = $target.find('.collection-item').length;
        }

        $this.click(function(){
            var proto = $target.data('prototype');
            $target.append('<div class="collection-item">'+proto.replace(/__name__/g, count)+'</div>');
            count++;
        });
    });

    // And remove
    $('body').delegate('[data-toggle="collection-remove"]', 'click', function(e){

        if(!$(this).data('ask') || confirm('Are you sure you want to remove this item?')){
            $(this).closest('.collection-item').remove();
        }

        e.preventDefault();
        e.stopPropagation();
    });
});
