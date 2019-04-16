<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        *{ box-sizing: border-box; }
        html,body{ font-family:Arial, Helvetica, sans-serif; padding:0; margin: 0; font-size:0.9em ; }
        a{color: #35a4f2; text-decoration: none; }
        li,ul{ list-style: none; padding:0;margin: 0;}
        input{min-width: 6em; }
        hr{color: antiquewhite;}
        form{ display: inline-block;}

        .controls{ text-align: center; background-color: #35a4f2; display: flex;padding: .4em; justify-content: space-between;  flex-wrap: wrap; }
        .controls btn, .controls i{  }
        .btn-create-dir{ left: 2em ;}
        .breadcrumb{display: flex; justify-content: space-between; border-bottom: #DDD 1px solid; line-height: 3em; padding: 0 2em;}
        .breadcrumb i{ font-size: 2em; color: #35a4f2;}
        .popup .top{height: 3.1em; border-bottom: #DDD 1px solid; line-height: 3em;background-color: #35a4f2;}

        .form-control{line-height: 3em; height: 3em ;}

        .form-createDir,.form-upload,.form-rename, .url{ display: none; }

        .btn{padding: 0 2em;line-height: 3em ;height: 3em;display: inline-block ; vertical-align: top; background: transparent}
        .btn-link{ font-size: inherit;  border: none; cursor: pointer;}
        .btn-link:hover{ background: #0d88c1;}
        .btn-action{border: none;color: #FFF;cursor: pointer; }
        .paste{ display: none;}
        .cut-exists{display: inline-block }
        .btn-upload{ background: #449d44;color:#FFF;}
        .btn-create-dir , .btn-link {color:#FFF;}


        .listing ul {margin: 1em 0 0 1em;}
        .listing li{background: #FAFAFA ; height: 8em ;width: 8em ; display: inline-block ;  margin: 0 1em 1em 0;cursor: pointer;text-align: center;overflow-wrap: break-word; vertical-align: top;  }
        .listing li i{ line-height: 1em; font-size: 3em; display: block; padding: .5em 0 ;}
        .listing li a{ display: block; height: 8em;}
        .listing li .title{ font-size: 12px ;}
        .listing li img{max-width: 100%;max-height: 6em;border: solid lightgray 1px;}
        .listing li .img{ height: 6em ;}

        #main{ max-width: 100%; }
        /**/
        @media (max-width:900px){
            .listing{ font-size: 0.5em ;}
        }

        .popup {
            text-align: center;  display:none ;z-index: 3;border: solid lightgray 5px;background-color: white;position: fixed; overflow:auto; left: 10%;right: 10%;top:10%; bottom: 10%}
        .popup-mask{display:none ;z-index: 2;background: rgba(0,0,0,0.7);position: fixed;left: 0;right: 0;top:0;bottom: 0;}
        body.open .popup,body.open .popup-mask, .cut{ display: block }

        @font-face {
            font-family: 'fs';
            src: url(data:font/truetype;charset=utf-8;base64,<?= base64_encode(file_get_contents(dirname(__FILE__) . "/fs.ttf")) ?>);
            font-weight: normal;
            font-style: normal;
        }
        [class^="icon-"]:before, [class*=" icon-"]:before {
            font-family: "fs";
            font-style: normal;
            font-weight: normal;
            speak: none;
            display: inline-block;
            text-decoration: inherit;
            width: 1em;
            margin-right: .2em;
            text-align: center;
            font-variant: normal;
            text-transform: none;
            line-height: 1em;
            margin-left: .2em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .icon-rename:before { content: '\24'; } /* '$' */
        .icon-upload:before { content: '\2c'; } /* ',' */
        .icon-download:before { content: '\e800'; } /* '' */
        .icon-scissors:before { content: '\e801'; } /* '' */
        .icon-doc:before { content: '\e802'; } /* '' */
        .icon-cancel:before { content: '\e803'; } /* '' */
        .icon-back:before { content: '\e804'; } /* '' */
        .icon-upload-1:before { content: '\e805'; } /* '' */
        .icon-home:before { content: '\e806'; } /* '' */
        .icon-folder:before { content: '\e807'; } /* '' */
        .icon-link:before { content: '\e808'; } /* '' */
        .icon-pencil:before { content: '\e809'; } /* '' */
        .icon-ok:before { content: '\e80a'; } /* '' */
        .icon-paste:before { content: '\f0ea'; } /* '' */
        .icon-folder-open-empty:before { content: '\f115'; } /* '' */
        .icon-trash:before { content: '\f1f8'; } /* '' */
        .icon-i-cursor:before { content: '\f246'; } /* '' */

    </style>
    <title>FileSystem</title>
    <link rel="shortcut icon" href="">
</head>
<body>

<img id='aviary_img' style="display: none;">
<input type="hidden" id="base_url" value="<?= $base_url ?>">
<input type="hidden" id="cur_dir" value="<?= $current_dir_url ;?>">


<div class="controls">
    <div class="createFolder">
         <span class="btn btn-link btn-create-dir">
        <i class="icon-folder-open-empty icon-folder-add"></i>
     </span>
        <form  method="post" class="form-createDir">
            <input type="text" name="dir" class="form-control" required>
            <input type="hidden" name="action" value="create_dir">
            <button class="btn btn-action" type="submit"> <i class="icon-ok"></i></button>
        </form>
    </div>
    <div class="upload">
        <label for="fileUpload" class="btn btn-link">
            <i class="icon-upload-1 icon-upload-1"></i>
        </label>


        <form method="post">
            <input type="text" name="url" class="form-control url" placeholder="coller l'url" required>
            <input type="hidden" name="action" value="uploadByUrl">
            <button class="btn btn-action btn-link" type="submit"><i class="icon-upload"></i></button>
        </form>
    </div>
    </form>
    <form class="form-upload" method="post" enctype="multipart/form-data">
        <input id="fileUpload" onchange="this.form.submit()" type="file" class="form-control" name="fileupload" >
        <input type="hidden" name="action" value="upload">


    </form>



</div>



<div class="breadcrumb" data-folder="<?= $current_dir ?>">
         <span>
        <a href="?path="><i class="icon-home"></i></a>
       <?= $current_dir  ?>
         </span>
    <span class="paste ">

        <form method="post" class="form-paste">
            <input type="hidden" name="action" value="paste">
            <button type="submit" class="btn btn-action"> <i class="icon-paste"></i></button>

        </form>
            <button class="btn btn-link btn-cancel"> <i class="icon-cancel"></i> </button>
    </span>

</div>

<div class="error">
    <?= isset($fs->error)  ;?>
</div>




<div class="listing">

    <ul>
        <? if ($parent_dir){ ?>
            <li>
                <a href="?path=<?= $parent_dir; ?>">
                    <i class="icon-back"></i>
                    <span class="title">Back</span>
                </a></li>
        <? } ?>

        <? foreach ($dirs as $dir){?>
            <li>
                <a href="?path=<?= $dir['base_path']; ?>">
                    <i class="icon-folder"></i>
                    <span class="title"><?= $dir['title']; ?></span>
                </a>
            </li>
        <? }; ?>
        <? foreach ($files as $file){ ?>
            <li class="file" data-json='<?= json_encode($file) ; ?>' >
                <div class="img"><img src="<?= $file['url']; ?>" alt=""> </div>
                <span class="title"><?= $file['name']; ?></span>
            </li>
        <? }; ?>
    </ul>
</div>

<div class="popup-mask" onclick="$('body').toggleClass('open')"></div>
<div class="popup">
    <div class="top">
        <span class="btn btn-link close"><i class="icon-cancel"></i></span>

        <form method="post" class="form-download">
            <input type="hidden" name="action" value="download">
            <input type="hidden" name="path" value="">
            <button type="submit"  class="btn btn-link"><i class="icon-download"></i></button>
        </form>


        <span class="btn btn-link btn-rename"><i class="icon-rename"></i></span>

        <form  method="post" class="form-rename" action="">
            <input type="text" name="newname" class="form-control" required>
            <input type="hidden" name="action" value="rename">
            <input type="hidden" name="filename" >
            <button type="submit" class="btn btn-action"><i class="icon-ok"></i></button>
        </form>

        <span class="btn btn-link btn-cut"><i class="icon-scissors"></i></span>

        <span class="btn btn-link btn-edit">
            <i class="icon-pencil"></i>
        </span>

        <form method="post" class="form-delete">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="path" value="">
            <button type="submit" class="btn btn-link"><i class="icon-trash"></i></button>
        </form>

        <i class="btn btn-link" id="link"><i class="icon-link" ></i></i>
    </div>



    <img src="" alt="" id='main' data-name="" >
    <div id="file_name"></div>
    <div id="file-info"></div>

</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<script type="text/javascript">
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


        $('#link').click(function () {
            parent.tinymce.activeEditor.windowManager.getParams().setUrl($('#main').attr('src'));
            parent.tinymce.activeEditor.windowManager.close();
        });

        $('.file').click(function (e) {
            $('body').addClass('open');

            _json = $(this).data('json') ;

            $('#main').attr('src',_json.url) ;
            $('#file_name').text(_json.name);

            $('[name="filename"]').val(_json.name);
            $('[name="path"]').val(_json.base_path);
            $('#aviary_img').attr('src',_json.url).attr('data-savepath',_json.path).data('info',_json).click(function(){
                console.log($(this).data('info'));
            });
        });



        $(".close").click(function () {
            $('body').removeClass('open');
        });

    });

    function reloaded() {
        window.location.href=window.location.href;
    }
</script>


</body>
</html>