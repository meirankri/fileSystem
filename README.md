#File System

Simple file system made with php and jquery
work with two parameters, the first is the absolute path, second is the relative path
that have to be call with the class 'FileSystem'

ex: $fs = FileSystem('c:/dir/to/image', 'image')

this file system made especially for images,

to add more extension to be show, add them in the array ext,

to add it as a plugin for tiny copy this folder into plugins folder of tinymce,
then add this script into the file
            tinymce.init({
            selector: "textarea",theme: "modern",width: 680,height: 300,
            plugins: [
                " advlist autolink  link filesystem image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu table directionality emoticons paste textcolor  code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "|  link unlink anchor | image media | forecolor backcolor  | print preview code "
            });
            
             
and this style
 
   .mce-filesystem{
                         width: 80% !important;
                         left:10% !important;
                         top:  10% !important;
                         height: 80% !important;
                     }
                     .mce-filesystem .mce-container-body{
                         width: 100% !important;
                         height: 100% !important;
                     }
                     .mce-reset{
                         height: 100% !important;
                     }
             
             
         
    
    