<?php



class Database
{
    public $db;
    public $result;
    function connect(){
        $this->db = new mysqli(Config::DbHost, Config::DbUser, Config::DbPassword, Config::DbTable);
        $this->db->set_charset('utf8');
        if (mysqli_connect_error()) {
           return false;
        }

    }

    public function query($query){

        $this->result = $this->db->query($query);

        return $this->result;
    }
    public function get($single=false){
            if($this->result != false) {
                if ($single) {
                    return $this->result->fetch_object();
                } else {
                    return $this->result->fetch_all(MYSQLI_ASSOC);
                }
            }

    }
}

