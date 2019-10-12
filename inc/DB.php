<?php 


class DB
{
    private static $db;

    /**
     * Подключение к бд
     * @return [object] PDO
     */
    public static function getDBO()
    {
        if (!self::$db)
        {
        	self::$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        } 
        return self::$db;
    }
}