
var Isometriks = (function(){
    redactor_options = {
        buttonSource: true,
        formattingTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        dragImageUpload: true,
        convertDivs: false,
        toolbarFixed: false,
        linkProtocol: false,
        plugins: ['imagemanager', 'definedlinks', 'filemanager']
    };

    return {
        redactor_options: redactor_options
    };

})();