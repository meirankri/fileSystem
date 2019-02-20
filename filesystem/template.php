<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fontello/css/fs.css">
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
<script src="https://dme0ih8comzn4.cloudfront.net/imaging/v3/editor.js"></script>
<script src="js/script.js"></script>
</body>
</html>