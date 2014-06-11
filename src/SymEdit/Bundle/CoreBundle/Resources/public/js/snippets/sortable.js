jQuery(function($) {

    function sortStop(e, ui){

        var index = ui.item.index();
        var id = ui.item.data('id');

        if ($(this).data('url')) {
            $.ajax({
                url: $(this).data('url'),
                data: {
                    id: id,
                    index: index
                },
                type: 'POST'
            });
        }
    }

    $('[data-toggle="sortable"]').sortable({
        update: sortStop
    }).disableSelection();
});
