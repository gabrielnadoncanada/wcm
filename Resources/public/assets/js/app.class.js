
$.Class({
    namespace: 'app',

    initTiny: function() {
        if ($('textarea.textarea-tiny-mce').length > 0) {
            tinymce.init({
                selector: 'textarea.textarea-tiny-mce',
                height: 500,
                menubar: false,
                plugins: [
                    'advlist autolink lists link anchor',
                    'searchreplace visualblocks code fullscreen',
                    'table paste code responsivefilemanager'
                ],
                toolbar: 'undo redo | ' +
                    'bold italic | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist | ' +
                    'removeformat code',
                external_filemanager_path: "/bundles/wcm/assets/js/filemanager/",
                filemanager_title: "Gestionnaire de fichiers",
                external_plugins: {
                    "responsivefilemanager": "plugins/responsivefilemanager/plugin.min.js",
                    "filemanager": "/bundles/wcm/assets/js/filemanager/plugin.min.js"
                },
            });
            $('input[type=submit]').on('click', function(e){
                let tiny_content = tinyMCE.activeEditor.getContent({format : 'raw'});
                $('.textarea-tiny-mce').val(tiny_content);
                $('.textarea-tiny-mce').show();
                $("form").submit();
            })

        }


    }
});

