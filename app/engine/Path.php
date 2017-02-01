<?php

class Path
{

    const Controller = 'app/controller';
    const Model = 'app/model';
    const View = 'app/view';
    const Source = 'app/source';
    const Engine = 'app/engine';

    function getPath(){
        if($_GET['q'] == NULL){
            return array('index');
        }else{
            return explode('/',$_GET['q']);
        }



    }
}
