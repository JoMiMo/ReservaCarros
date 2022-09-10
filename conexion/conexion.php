<?php
  class connection{

    private $url= 'mysql:host=localhost;dbname=db_autos';
    private $usuario = 'root';
    private $pass = '';
    private $conn;

    public function __construct(){

        try{
            $this->conn = new PDO($this->url,$this->usuario,$this->pass);
        }catch( PDOException $e){
        print "¡Error!: " . $e->getMessage() . "<br>";
        die();
        }
    }

    public function get_connection(){
        return $this->conn;

    }
  }
?>
