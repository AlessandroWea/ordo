<?php

namespace Ordo\Database;

use \PDO;

class Db
{
    public static $db = null;

    public static function connect()
    {
        if(static::$db == null)
            return static::$db = new PDO('mysql:host='. DB_HOST .';dbname=' . DB_NAME, DB_USER, DB_PWD);
        
        return static::$db;
    }

    public function query($sql, $arr = [])
    {
        $db = Db::connect();
        $query = $db->prepare($sql);
        $query->execute($arr);
        $errInfo = $query->errorInfo();
        if($errInfo[0] !== PDO::ERR_NONE)
        {
            echo $errInfo[2];
            exit();
        }
        $db = null;
        return $query;
    }
}