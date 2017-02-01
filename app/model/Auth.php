<?php



class ModelAuth
{
    public $user;
    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
        $this->user = new User();
    }

    private function checkName($name){

        if(strlen($name) < 3){
            return array('status'=>false,'text'=>'Name must contain minimum 3 letters');
        }


        $res = $this->user->getAll('name');
        foreach ($res as $row){
            if($row['name'] == $name){
                return array('status'=>false,'text'=>'Name already used');
            }
        }
        return array('status'=>true,'text'=>'');

    }
    private function checkPassword($password){

        if(strlen($password) < 3){
            return array('status'=>false,'text'=>'Password must contain minimum 3 letters');
        }


        return array('status'=>true,'text'=>'');

    }
    public function createUser($name,$password){

        $nameCheck = $this->checkName($name);
        $passwordCheck = $this->checkPassword($password);
        $res = true;
        if(!$nameCheck['status'])
            $res = false;
        if(!$passwordCheck['status'])
            $res = false;

        if(!$res){
            return array(
                'status'=>false,
                'name'  => $nameCheck,
                'password'  => $passwordCheck,
            );
        }
        $salt = rand();
        $password = md5($salt.$password);
        $result = $this->db->query("INSERT INTO User (name,password,salt) VALUES ('$name','$password','$salt')");

        return array('status'=>true,'res'=>$result);
    }
    public function loginUser($name,$password){
       $result = $this->user->get('name="'.$name.'"',$password);

        if($result != false){
            $_SESSION['user'] = array(
                'id'=>$result['id'],
                'code'=>$result['salt']
            );
        }
        return $result;
    }
}