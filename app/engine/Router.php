<?php


class Router
{

    function Start(){

        $path = Path::getPath();
        if($path[0] == 'ajax'){
            array_shift($path);

        }

        $boot = new Bootstrap();
        $boot->addFile('model',ucfirst($path[0]),true);

        $controller_file = $boot->addFile('controller',ucfirst($path[0]),true);

        if($controller_file != false){
            $controller_name = 'Controller'.ucfirst($path[0]);

            if(isset($path[1])){
                $action = 'action'.ucfirst($path[1]);
            }else{
                $action = 'actionIndex';
            }

            $controller = new $controller_name();
            $controller->$action();
        }else{
            /*404*/
        }

    }

}