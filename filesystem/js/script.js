$(document).ready(function() {

    $('.btn-create-dir').click(function(){
       $('.form-createDir').toggle();
    });

    $('.btn-upload').click(function(){
        $('.form-upload').toggle();
    });
    $('.icon-upload').closest('.btn').click(function(){
        $('.url').toggle();
    });


    $('.btn-rename').click(function(){
        $('.form-rename').toggle();
    });



    if (document.cookie.indexOf('nameCut=')> -1) {

        $('.paste').addClass("cut-exists") ;
    }

    $('.btn-cut').click(function () {
        document.cookie = "nameCut="+$('input[name="path"]').val()+"; expires"+(Date.now()+540000)+""; //15min
        reloaded();
    });

    $('.btn-cancel').click(function () {
        document.cookie = "nameCut=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
        reloaded();
    });

    $('.form-delete button').click(function(){
        if(!confirm('etes-vous sur de supprimer ce fichier')){
            return false;
        }
    });
    $('.btn-edit').click(function () {
        function _launch(){
            featherEditor.launch({image: 'aviary_img', url: $('#aviary_img').data('src')} ) ;
            return false ;
        }
        $('#aviary_img').attr('src',$('#aviary_img').data('src')).load( _launch )  ;
    });

    $('#link').click(function () {

        parent.tinymce.activeEditor.windowManager.getParams().setUrl($('#main').attr('src'));
        parent.tinymce.activeEditor.windowManager.close();
    });

    $('.file').click(function (e) {
        $('body').addClass('open');

        _json = $(this).data('json') ;

        $('#main').attr('src',_json.url) ;
        $('#file_name').text(_json.name);
        $('#file-info').text(JSON.stringify(_json)) ;

        $('[name="filename"]').val(_json.name);
        $('[name="path"]').val(_json.base_path);
        $('#aviary_img').data('src', _json.url);
    });



    $(".close").click(function () {
        $('body').removeClass('open');
    });

});

function reloaded() {
    window.location.href=window.location.href;
}

var featherEditor = new Aviary.Feather({
    'apiKey' : "3d1c5a5cd321415eaeb2460243b711ec",
    'language' : 'fr' ,
    'theme' : 'light' ,
    'tools' : 'all',
    'maxSize'  : '1400' ,
    onReady: function() { },
    onSave: function(imageID, newURL) {
        var img = document.getElementById(imageID);
        img.src = newURL;
        $.ajax({
            type: "POST",
            url: "ajax_calls.php?action=save_img",
            data: { url: newURL, path:'/web/', name:'2.jpg' }
        }).done(function( msg ) {
            featherEditor.close();
            reloaded();
        });

        return false;
    },
    onError: function(errorObj) {
        alert(errorObj.message);
    }
});
