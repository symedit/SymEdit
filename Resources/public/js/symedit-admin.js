
var Isometriks = (function(){

    redactor_iframe = {
        iframe: true,
        autoresize: true,
        minHeight: 400
    };

    redactor = {
        createSpans: function(){
            var rows;
            if(rows = prompt('Enter column widths comma separated, should add to 12.', '6,6')){
                rows = rows.split(',');
                var html = '';
                for(var i=0; i<rows.length; i++){
                    html += '<div class="col-md-' + rows[i].trim() + '"><p>Span ' + rows[i] + '</p></div>';
                }
                return html;
            }

            return false; 
        },

        row: function(){
            var html;
            if(html = redactor.createSpans()){
                this.focus(); console.log('<div class="row">' + html + '</div>');
                this.execCommand('inserthtml', '<div class="row">' + html + '</div>');
            }
        },

        heroUnit: function(){
            var html = '<div class="hero-unit"><h1>Caption</h1><p>Sub Text</p><p><a href="#" class="btn btn-large btn-primary">Learn More &raquo</a></p></div>';
            this.focus();
            this.execCommand('inserthtml', html);
        }
    };


    redactor_options = {
        formattingTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        dragUpload: true,
        convertDivs: false,
        buttonsAdd: ['|', 'bootstrap'],
        buttonsCustom: {
            bootstrap: {
                title: "Bootstrap Commands",
                dropdown: {
                    row: {
                        title: 'Insert Row',
                        callback: this.redactor.row
                    },

                    hero_unit: {
                        title: 'Insert Hero Unit',
                        callback: this.redactor.heroUnit
                    }
                }
            }
        }
    };

    return {
        redactor_options: redactor_options,
        redactor_iframe: redactor_iframe
    };

})();