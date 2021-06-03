
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
                    'table paste code'
                ],
                toolbar: 'undo redo | ' +
                    'bold italic | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist | ' +
                    'removeformat code',
            });
            $('label[for=submit]').on('click', function(e){
                let tiny_content = tinyMCE.activeEditor.getContent({format : 'raw'});
                $('.textarea-tiny-mce').val(tiny_content);
                $("form").submit();
            })
        }


    }
});

