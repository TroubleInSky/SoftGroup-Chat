<?php


class View
{

    public function generate($file,$string='',$template='default'){
        $path = Path::getPath();
        if($path[0] == 'ajax'){
            if(is_array($string)){
               echo json_encode($string);

            }else{
                echo $string;

            }
            return 'ajax';
        }
        if(is_array($string)){
            extract($string, EXTR_PREFIX_SAME, "new_");
        }
        $boot = new Bootstrap();
        $path = $boot->getFilePath('view',$file);
        include ($path);


    }
}