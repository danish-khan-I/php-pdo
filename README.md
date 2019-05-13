# php-pdo
php pdo made easy using class.


`pdo.php`

```
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
}

```

Include `pdo.php` to your working file... recommend headers you can access it throughout all pages.
```
<?php 
include_once 'pdo.php';
// initialize
// above class be initialize as 
$db = new db("localhost","test_db","root",""); // define in your header you can access it anywhere thoughout the page

```
## select example

`$allData = $db->query("SELECT * FROM users");`

## prepared query
`$preparedData = $db->query("SELECT * FROM users WHERE age > ?",[18]);`
## multiple prepared
```
//prepare SELECT, multiple conditions

$active = 1;

$preparedData = $db->query("SELECT * FROM users WHERE age > ? AND is_active = ?",[18,$active]);
```

## Others
```
//Update Example
$db->query("UPDATE users SET age = 18 WHERE age = ?",[17]);

//delete
$db->query("DELETE FROM users WHERE age = 18");

// Joins
$db->query("SELECT users.*,address.address LEFT JOIN address ON address.user_id = users.id WHERE users.id = ?",[1]);
```
## Change Fetch mode without having prepared data
```
$db->query('SELECT * FROM users',[],PDO::FETCH_COLUMN); // notice empty array as second arg.
```
# GET Last Inserted Id
`$db->lastId()`
