// Media.js

jQuery(function($) {

    var modalId = 'symedit-media-choose-modal';
    var $current;
    var dropzone;

    $('[data-toggle="symedit-choose-image"]').click(function() {

        $current = $(this);

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
            dropzone.on('success', uploadImage);

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
        $modal.on('click', '[data-toggle="remove"]', removeImage);
        $modal.on('click', '[data-toggle="choose"]', chooseImage);

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

    function removeImage()
    {
        getForm().val('');
        getModal().modal('hide');
        getContainer().addClass('no-data').removeClass('has-data');
    }

    function uploadImage(file, response)
    {
        var id = response.id;
        var path = response.filelink;

        // Hide Modal
        getModal().modal('hide');

        // Set form values
        getForm().val(id);
        getContainer().addClass('has-data').removeClass('no-data');
        getContainer().find('> img').attr('src', path);
    }

    function chooseImage()
    {
        var $selected = getModal().find('input[name=symedit-media-choose]:checked');

        // Hide modal regardless
        getModal().modal('hide');

        if (!$selected.size()) {
            return;
        }

        getForm().val($selected.val());
        getContainer().addClass('has-data').removeClass('no-data');
        getContainer().find('> img').attr('src', $selected.data('preview'));
    }
});