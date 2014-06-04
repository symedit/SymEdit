jQuery(function($) {

    function sortStop(e){
        $target = $(e.target);
        var order = 0;
        var pairs = {};

        $target.find('> [data-id]').each(function(){
            pairs[$(this).data('id')] = order++;
        });

        if ($(this).data('url')) {
            $.ajax({
                url: $(this).data('url'),
                data: { pairs: pairs },
                type: 'POST'
            });
        }
    }

    $('[data-toggle="sortable"]').sortable({
        update: sortStop
    }).disableSelection();
});
