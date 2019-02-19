<?php

class FileSystem{

    public $base ;
    public $base_uri ;

    public $current_dir ;
    public $current_dir_uri ;

    public $parent_dir ;
    public $ext = ['jpeg','jpg','gif','png','pdf'];
    

    public $ds = DIRECTORY_SEPARATOR ;

    public function __construct($absolutPath, $relativePath) {
        header ('Content-type: text/html; charset=utf-8');

        $scheme=isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ?'https':'http';
        $base=rtrim( strtr(dirname($_SERVER['SCRIPT_NAME']),'\\','/') ,'/');
        $uri=parse_url((preg_match('/^\w+:\/\//',$_SERVER['REQUEST_URI'])?'': $scheme.'://'.$_SERVER['SERVER_NAME']).$_SERVER['REQUEST_URI']);

        $this->base = $absolutPath ;
        //$this->base = __DIR__ ;

       //$this->base_uri = $uri['scheme'] .'://'. $uri['host'] . $uri['path'] ;
        $this->base_uri = $uri['scheme'] .'://'.$relativePath.'/';


        //set working path
        if (isset($_GET['path']))
          $this->parent_dir = $_GET['path'] ? $_GET['path'] == '\\' ? '' : dirname($_GET['path']) : '' ;

        $this->current_dir = isset($_GET['path'] ) ? str_replace($this->base, '', $_GET['path']) : ''  ;
        $this->current_dir_uri = str_replace($this->ds , '/' , $this->current_dir ) ;
    }

    public function action(){
        function post($s){return isset($_POST[$s]) ? $_POST[$s] : null ; }

        switch (post('action')){
            case 'delete' :
                $del = ltrim(post('path'), '\\');
                $this->delete($del);
                break ;
            case 'rename' :
                $this->rename(post('filename'), post('newname'));
                break ;

            case 'paste' :
                $this->paste($_COOKIE['nameCut']);
                setcookie("nameCut", "", time()-3600);
                break ;
            case 'download' :
                $this->download(post('path'));
                break ;
            case 'upload' :
                $this->upload($_FILES['fileupload']);
                break ;
            case 'uploadByUrl' :
                $this->upload_from_url(post('url'));
                break ;

            case 'create_dir' :
                $this->create_dir(post('dir'));
                break ;


        }
    }

    public function list_dir(){
        $dirs =  glob($this->base . $this->current_dir.'/*',GLOB_ONLYDIR);
        $out = [] ;
        foreach ($dirs as $dir){
            $out[] = [ 'name'=> basename($dir)
                , 'path' => realpath($dir)
                , 'url' => $this->base_uri . $dir
                , 'base_path'=> str_replace($this->base,'',realpath($dir))
            ] ;
        }
       // p($out);
        return $out;
    }

    public function list_file() {
        $files = glob($this->base . $this->current_dir .'/*.*');
        $out = [] ;
        foreach ($files as $file){
            if (in_array(strtolower($this->get_ext($file)), $this->ext)){
                if($this->get_ext($file)  === 'pdf'){
                    $out[] = [ 'name'=> basename($file)
                        , 'path' => realpath($file)
                        , 'url'=>$this->base_uri . '/pdf.jpg'
                        ,'ext' => $this->get_ext($file)
                    ] ;

                }else{
                    $out[] = [ 'name'=> utf8_encode ( basename($file) )
                        , 'path' => realpath($file)
                        , 'base_path'=> str_replace($this->base,'',realpath($file))
                        , 'url' => $this->base_uri  .$this->current_dir_uri  .'/'. utf8_encode( basename($file))
                        ,'ext' => $this->get_ext($file)
                    ] ;
                }
            }
            //p($out) ;
        }
        return $out;
    }

    public function get_ext($file){
        if (is_array($file)){
            $filename = $file['name'];
            return pathinfo($filename, PATHINFO_EXTENSION);
        }
         $mime = explode("/",@mime_content_type($file));


         return end($mime);
    }

    public function rename($oldname, $Name) {
        $path = trim($this->base . $this->current_dir.$this->ds.$oldname);
        $filePath = trim($this->base . $this->current_dir .$this->ds.$Name .'.'.$this->get_ext($path) );
        if (!file_exists($path) or is_dir($path) or file_exists($filePath) || preg_match('^\w^', $Name) != 1)
            return false;
        return rename($path,$filePath);
    }

    public function delete($path) {

        if (!file_exists($this->base.'\\'.$path))
            return false;
            unlink(trim($this->base.'/'.$path));
            return true;
    }

    public function create_dir($name) {
        $name = $this->base . $this->current_dir.$this->ds.$name;
        if (file_exists($name)) return false;
            return mkdir($name);
    }

    public function paste($file){
        $src = $this->base.trim($file);
        $dst = $this->base.trim($this->current_dir .$this->ds.basename($src));
         rename($src, $dst);
    }

    public function download($file){
        if (!is_file($this->base.$file)) return ;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($this->base.$file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->base.$file));
        readfile($this->base.$file);
        exit;
    }

    public function upload($file){
        if (in_array(strtolower($this->get_ext($file)), $this->ext)) {
             $uploadfile = $this->base . $this->ds . $this->current_dir . $this->ds . basename($file['name']);
                move_uploaded_file($file['tmp_name'], $uploadfile);


        }

    }

    public function upload_from_url($url){
        if(!empty($url)){
            $img = file_get_contents($url);
            $url = explode('/', $url);
            $url = end($url);
            $path = $this->base.$this->current_dir.$this->ds.$url;
            file_put_contents($path,$img );

        }
    }

}