// http://stackoverflow.com/questions/659508/how-can-i-shift-select-multiple-checkboxes-like-gmail
$(function(){
    var $areas = $('.checkbox-multi-select');

    $areas.each(function() {
        var lastChecked = null;
        $boxes = $('input[type=checkbox]', this);

        $boxes.click(function(e) {
            if(!lastChecked) {
                lastChecked = this;
                return;
            }

            if(e.shiftKey) {
                var start = $boxes.index(this);
                var end = $boxes.index(lastChecked);

                $boxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);

            }

            lastChecked = this;
        });
    });
});
