<?php



class ControllerAuth
{
    function __construct()
    {
        $this->model = new ModelAuth();
    }

    function actionIndex(){

        if($_POST){

            $name = $_POST['name'];
            $password = $_POST['password'];



            $result = $this->model->loginUser($name,$password);
            if($result){

                  header('Location: /');
            }
            View::generate('login',array('result'=>$result));

        }else{
            View::generate('login',array('content'=>'1'));
        }
    }

    function actionRegister(){

        if($_POST){

            $name = $_POST['name'];
            $password = $_POST['password'];



            $result = $this->model->createUser($name,$password);
            if($result['status']){
                header("Location: /");
            }
            View::generate('register',array('result'=>$result));

        }else{
            View::generate('register',array('content'=>'1'));
        }



    }
    function actionLogout(){
        unset($_SESSION['user']);
    }
}