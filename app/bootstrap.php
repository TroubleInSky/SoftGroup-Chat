<?php
session_start();
include('engine/Path.php');
include('engine/Router.php');

class Bootstrap
{


    public function getFilePath($type,$value){

        switch (strtolower($type)) {

            case 'controller':
                $type = Path::Controller;
                break;
            case 'model':
                $type = Path::Model;
                break;
            case 'view':
                $type = Path::View;
                break;
            case 'source':
                $type = Path::Source;
                break;
            case 'engine':
                $type = Path::Engine;
                break;
            case 'other':
                $type = '';
                break;
            default:
                return false;
        }

        if($type == ''){
            $path = $value.'.php';
        }else{
            $path = $type.'/'.$value.'.php';
        }

        return $path;
    }
    public function addFiles($files = false){
        /*
         * $type = model | controller | view | source | engine
         * $file = array(
         *  array($type,value,include_once(optical,if you want include file by this function insert true, default false))
         * );
         *
         * */
        if(!$files)
            return 'Error';
        if(!is_array($files))
            return 'Error';

        foreach ($files as $file){

            $path = $this->getFilePath($file[0],$file[1]);

            if((isset($file[2])) && ($file[2] == true)){

               $status = include_once($path);

            }else{

               $status = include($path);

            }
            $res[] = array(
                $path,$status
            );
        }

        return $res;
    }
    public function addFile($type,$value,$include_once=false){
        /*
         *  $type = model | controller | view | source | engine
         *  value = string
         *  include_once(optical,if you want include file by this function insert true, default false))
         *
         * */


                $path = $this->getFilePath($type,$value);

                if($include_once){

                    $status = include_once($path);


                }else{
                    $status = include($path);

                }




        return $status;
    }


}

$bootstrap = new Bootstrap();

$router = $bootstrap->addFiles(array(array('engine','Config',true),array('engine','Database',true),array('engine','Router',true),array('engine','View',true),array('engine','User',true)));

Router::Start();