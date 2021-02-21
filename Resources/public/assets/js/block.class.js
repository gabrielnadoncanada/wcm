$.Class({
    namespace: 'block',


    initEditor: function() {
        if ($('textarea.codemirror').length > 0) {
            this.editor = CodeMirror.fromTextArea($('textarea.codemirror').get(0), {
                mode: "htmlmixed",
                theme: "material",
                indentUnit: 4,
                lineNumbers: true,
                autoCloseBrackets: true,
                matchBrackets: true,
                lineWrapping: true,
                autoCloseTags: true,
                matchTags: true,
                styleActiveLine: true,
                height: '100%',
                viewportMargin: 0
            });
        }
    }
});









