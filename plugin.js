
tinymce.PluginManager.add('filesystem', function(editor) {
    editor.settings.file_browser_callback =  function (id, value, type, win) {
        tinymce.activeEditor.windowManager.open({
            title: "file manager",
            file: tinymce.PluginManager.urls['filesystem'] ,
            classes:'filesystem',
            inline: 1
        }
        , {
            setUrl: function (url) {
                var fieldElm = win.document.getElementById(id);
                fieldElm.value = editor.convertURL(url);
                if ("createEvent" in document) {
                    var evt = document.createEvent("HTMLEvents");
                    evt.initEvent("change", false, true);
                    fieldElm.dispatchEvent(evt)
                } else {
                    fieldElm.fireEvent("onchange")
                }
            }
        }

        );
    };
    return false;
});
