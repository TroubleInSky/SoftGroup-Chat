<?php



class ControllerIndex
{
    function __construct()
    {
        if(!User::loggedIn()){
            header('Location: auth');
        }

        $this->model = new ModelIndex();
    }

    function actionIndex(){
        if($_POST){
            $text = $_POST['text'];
            $parent = $_POST['parent'];
            $this->model->addComment($text,$parent);
        }

        $data = $this->model->getData();
        $path = Path::getPath();
        $user = new User();
        $currentUser = $user->getCurrent();
        if($path[0] == 'ajax'){
            $user = new User();
            $dat = '';
            foreach ($data as $row):
                if($row['arr']['text'] == ''){
                    continue;
                }
                $res = $user->get('id="'.$row['arr']['user'].'"');

             $dat .= '<div class="message">
                    <div class="wrap">

                        <div class="content">
                            <div class="name">
                                <h3>
                                    '.$res['name'].'
                                </h3>
                            </div>
                            <div class="text">
                                '.$row['arr']['text'].'
                            </div>
                        </div>.';
                if($currentUser['id'] == $res['id']){

                    $dat .= ' <a class="edit" data-id="'.$row['arr']['id'].'" href="/index/edit/'.$row['arr']['id'].'">edit</a>';
                    $dat .= '    <a class="delete" data-id="'.$row['arr']['id'].'" href="/index/delete/'.$row['arr']['id'].'">delete</a>';


                }else{

                    $dat .= ' <a class="comment" data-comment="'.$row['arr']['id'].'" href="?comment='.$row['arr']['id'].'">comment</a>';

                }



$dat .= '</div>';
                if($row['comments'] != array()):
                    foreach ($row['comments'] as $r):
                        $res = $user->get('id="'.$r['user'].'"');

                     $dat.=   '<div class="message comment">
                            <div class="wrap">

                                <div class="content">
                                    <div class="name">
                                        <h3>
                                            '.$res['name'].'
                                        </h3>
                                    </div>
                                    <div class="text">
                                        '.$r['text'].'
                                    </div>
                                </div>';

                if($currentUser['id'] == $res['id']){

                    $dat .= ' <a class="edit" data-id="'.$row['arr']['id'].'" href="/index/edit/'.$row['arr']['id'].'">edit</a>';
                    $dat .= '    <a class="delete" data-id="'.$row['arr']['id'].'" href="/index/delete/'.$row['arr']['id'].'">delete</a>';


                }else{

                    $dat .= ' <a class="comment" data-comment="'.$row['arr']['id'].'" href="?comment='.$row['arr']['id'].'">comment</a>';

                }



                $dat .= '</div></div>';



                    endforeach;
                endif;
            endforeach;

            $result = View::generate('index',$dat);
        }else{
            $result = View::generate('index',array('data'=>$data));
        }





    }

    function actionEdit(){
       if($_POST){
            $val = $_POST['id'];
        }else{
           $path= new Path();
           $p = $path->getPath();
           $val = $p['2'];
       }
        $user = new User();
        $userId = $user->getCurrent();
        $userId = $userId['id'];
        $data = $this->model->getData($val);
        if($data['user'] == $userId) {
            $id = $_POST['id'];
            $text = $_POST['text'];
            $this->model->editComment($id,$text);
        }
    }

    function actionDelete(){
        $user = new User();
        $userId = $user->getCurrent();
        $userId = $userId['id'];
        if($_POST){
            $val = $_POST['id'];
        }else{
            $path= new Path();
            $p = $path->getPath();
            $val = $p['2'];
        }
           $data = $this->model->getData($val);
            if($data['user'] == $userId){
                $this->model->removeComment($val);
            }
    }
}