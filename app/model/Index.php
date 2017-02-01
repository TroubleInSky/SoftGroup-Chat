<?php



class ModelIndex
{
    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function getData($id = false){
        if($id == false){
            $this->db->query('SELECT * FROM chat ORDER BY parent');
            $res = $this->db->get();



            $result = array();
            foreach($res as $value){

                if($value['parent'] == 0){
                    $result[$value['id']] = array(
                        'arr' => $value,
                        'comments' => array()
                    );
                }else{
                    $result[$value['parent']]['comments'][$value['id']] =  $value;
                }

            }


            return  $result;
        }else{
            $this->db->query('SELECT * FROM chat  WHERE id="'.$id.'"');

            $res = $this->db->get();
            return $res[0];
        }

    }
    public function addComment($text,$parent = 0){

        $user = User::getCurrent();
        $user = $user['id'];
        if($text != ''){

            $res=$this->db->query("INSERT INTO chat (parent,user,text) VALUES ('$parent','$user','$text')");
        }else{
            return false;
        }

    }
    public function removeComment($id){

        $user = User::getCurrent();
        $user = $user['id'];
        $res=$this->db->query("DELETE FROM chat WHERE id='$id'");
        return $res;

    }
    public function editComment($id,$text){
        $res=$this->db->query("UPDATE Chat SET text='$text' WHERE id='$id'");
    }
}