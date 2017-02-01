<?php


class User
{

    function __construct()
    {
        $this->db = new Database();

        $this->db->connect();
    }
    public function get($str,$password = false){
        $string = 'SELECT * FROM User WHERE '.$str;
        $this->db->query($string);
        $res = $this->db->get();
        $res = $res[0];

        if($res == array()){

            return false;
        }
        if($password != false){

            $password = md5($res['salt'].$password);

            if($password != $res['password'])

                return false;
        }

        return $res;
    }
    public function getCurrent(){
        $string = 'SELECT * FROM User WHERE id='.$_SESSION['user']['id'].' && salt="'.$_SESSION['user']['code'].'"';
        $this->db->query($string);
        $res = $this->db->get();
        return $res[0];
    }
    public function getAll($what = '*'){
         $this->db->query('SELECT '.$what.' FROM User');
        return $this->db->get();
    }
    public function loggedIn(){
        if(!isset($_SESSION['user'])){
            return false;
        }
       return true;
    }



}