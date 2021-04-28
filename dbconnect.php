
<?php

class DbUtil{
    public static $user = "YourComputingID";
    public static $pass = "YourPassword";
    public static $host = "usersrv01.cs.virginia.edu";
    public static $schema = "YourComputingID";
    public static function loginConnection() {
    $db = new mysqli(DbUtil::$host, DbUtil::$user,
        DbUtil::$pass, DbUtil::$schema);
        if($db->connect_errno) {
            echo "fail";
            $db->close();
            exit();
        }
        return $db;
    }
}
?>