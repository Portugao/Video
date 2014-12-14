CKEDITOR.plugins.add('MUVideo', {
    requires: 'popup',
    lang: 'en,nl,de',
    init: function (editor) {
        editor.addCommand('insertMUVideo', {
            exec: function (editor) {
                var url = Zikula.Config.baseURL + Zikula.Config.entrypoint + '?module=MUVideo&type=external&func=finder&editor=ckeditor';
                // call method in MUVideo_finder.js and provide current editor
                MUVideoFinderCKEditor(editor, url);
            }
        });
        editor.ui.addButton('muvideo', {
            label: editor.lang.MUVideo.title,
            command: 'insertMUVideo',
         // icon: this.path + 'images/ed_muvideo.png'
            icon: '/images/icons/extrasmall/favorites.png'
        });
    }
});