// Media.js

jQuery(function($) {

    var modalId = 'symedit-media-choose-modal';
    var $current;
    var dropzone;

    $('[data-toggle="symedit-media-choose"]').click(function() {

        $current = $(this);
        var type = $current.data('type');

        if (!$(this).data('url')) {
            return;
        }

        getModal().load($(this).data('url'), {}, function() {
            var currentValue = getForm().val();

            if (currentValue) {
                $(this).find('input[name=symedit-media-choose][value=' + currentValue + ']').prop('checked', 'checked');
            }

            // Setup dropzone
            dropzone = new Dropzone('#symedit-media-dropzone', {
                previewsContainer: '#symedit-media-preview'
            });
            dropzone.on('success', uploadMedia.bind({
                type: type
            }));

            $(this).modal();
        });
    });


    function getModal()
    {
        var $modal = $('#' + modalId);

        if ($modal.size()) {
           return $modal;
        }

        $modal = $('<div class="modal fade" id="' + modalId + '" />');
        $('body').append($modal);

        // Setup events
        $modal.on('click', '[data-toggle="remove"]', removeMedia);
        $modal.on('click', '[data-toggle="choose"]', chooseMedia);

        return $modal;
    }

    function getBlock()
    {
        return $current.closest('.symedit-media-choose');
    }

    function getForm()
    {
        return getBlock().find('> input[type=hidden]');
    }

    function getContainer()
    {
        return getBlock().find('.symedit-media-container');
    }

    function removeMedia()
    {
        getForm().val('');
        getModal().modal('hide');
        getContainer().addClass('no-data').removeClass('has-data');
    }

    function setValue(id, path, type)
    {
        // Set form value
        getForm().val(id);

        // Show the preview
        getContainer().addClass('has-data').removeClass('no-data');

        if (type === 'image') {
            getContainer().find('> img').attr('src', path);
        } else {
            getContainer().find('.symedit-media-file').text(path);
        }
    }

    function uploadMedia(file, response)
    {
        var id = response.id;
        var path = response.weblink;
        var type = this.type;

        // Hide Modal
        getModal().modal('hide');

        // Run Javascript for type
        setValue(id, path, type);
    }

    function chooseMedia()
    {
        var $selected = getModal().find('input[name=symedit-media-choose]:checked');
        var type = $current.data('type');

        // Hide modal regardless
        getModal().modal('hide');

        if (!$selected.size()) {
            return;
        }

        // Run Javascript for type
        setValue($selected.val(), $selected.data('preview'), type);
    }
});