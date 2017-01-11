
var Isometriks = (function(){
    redactor_options = {
        deniedTags: false,
        buttonSource: true,
        formattingTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        dragImageUpload: true,
        replaceDivs: false,
        toolbarFixed: false,
        linkProtocol: false,
        minHeight: 300,
        plugins: [
            'imagemanager',
            'definedlinks',
            'filemanager',
            'video'
        ]
    };

    return {
        redactor_options: redactor_options
    };

})();