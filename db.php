<?php 
class db
{
    private $database;
    public function __construct($host,$dbname,$user,$pwd){
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // enable exceptions
        // $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING); // in case if  you need to enable warning
        $this->database = $pdo;
    }
    public function query($query,$params = [],$method = PDO::FETCH_ASSOC){
        $statment = $this->database->prepare($query);
        $statment->execute($params);
        if(strtoupper(explode(' ',$query)[0]) == 'SELECT'){ // incase if you write select name instead of SELECT name
            $data  = $statment->fetchAll($method);  // by default i am using PDO::FETCH_ASSOC more can be found here https://www.php.net/manual/en/pdostatement.fetch.php
            return $data;
        }
    }
    public function lastId(){
        return $this->database->lastInsertId(); // just a note https://www.php.net/manual/en/pdo.lastinsertid.php
    }
    public function __destruct(){
        $this->database = null;
    }
}
