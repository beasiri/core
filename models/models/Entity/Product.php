<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 18.08.16
 * Time: 19:57
 */
class Product
{
    private $name;
    private $price;
    private $parentID;
    private $action = false;
    private $new = false;
//* @property mysqli conn
    static private $conn = null;

    static public function runSQL($sql)
    {
        self::$conn = mysqli_connect(dbconfig::HOST, dbconfig::LOGIN, dbconfig::PASSWORD, dbconfig::DATABASE);
        $result = mysqli_query( self::$conn, $sql );

        return $result;
    }
    static public function SelectAction()
    {
        $sql = 'select * from products where action = 1';

        return self::runSQL($sql);

    }
    static public function SelectNew()
    {
        $sql = 'select * from products where new = 1 ';

        return self::runSQL($sql);

    }
    static public function SelectAll()
    {
        $sql = 'select * from products ';

        return self::runSQL($sql);
    }

}