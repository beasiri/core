<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 18.08.16
 * Time: 19:57
 */
class Tovari
{
    private $id;
    private $name;
    private $price;
    private $parentID;
    private $action = false;
    private $new = false;
//* @property mysqli conn
    static private $conn = null;

    /**
     * выполнение запроса к БД через интерфейс mysqli
     * @param $sql
     * @return bool|mysqli_result
     */
    static public function runSQL($sql)
    {
        self::$conn = mysqli_connect(dbconfig::HOST, dbconfig::LOGIN, dbconfig::PASSWORD, dbconfig::DATABASE);
        $result = mysqli_query( self::$conn, $sql );

        return $result;
    }

    /**
     * отбор товаров по критерию участия в акции
     * @return bool|mysqli_result
     */
    static public function SelectAction()
    {
        $sql = 'select * from tovari where action = 1';

        return self::runSQL($sql);

    }

    /**
     * отбор товаров из категории новинки
     * @return bool|mysqli_result
     */
    static public function SelectNew()
    {
        $sql = 'select * from tovari where new = 1 ';

        return self::runSQL($sql);

    }

    /**
     * показ всех товаров
     * @return bool|mysqli_result
     */
    static public function SelectAll()
    {
        $sql = 'select * from tovari ';

        return self::runSQL($sql);
    }

    /**
     * получение товара по id
     * @param $id
     * @return bool|mysqli_result
     */
    public function fromID($id){
        $sql = "select * from tovari where id = {$id}";
        return self::runSQL($sql);
    }

    /**
     * получить количество товаров
     * @return mixed
     */
    static public function CountRecord()
    {
        $sql = 'select count(*) from tovari ';
        $result = self::runSQL($sql);
        $row = mysqli_fetch_assoc($result);
        return $row[0];
    }

    /**
     * 
     * @return array
     */
    static public function getIDs()
    {
        $sql = "select id from tovari ";
        $result = self::runSQL($sql);
        $arrResult = [];
        while( $row = mysqli_fetch_array($result))
        {
            $arrResult[] = $row[0];
        }
        return $arrResult;
    }
    

    /**
     * отбор записей по условиям в массиве $arrSearch
     *  fromBY( [ 'price' => '200', 'price' => [ 'ot' => '100', 'do' => '200' ] ])
     * @param array $arrSearch
     * @return bool|mysqli_result
     */
    static public function fromBy(array $arrSerch){
        $sql = "select * from tovari where ";
        $separator = '';
        foreach ($arrSerch as $key1 => $value1){
            if (is_array($value1)){
                foreach ($value1 as $key2 => $value2 ){
                    switch ($key2) {
                        case 'ot':
                            $sql.= "$separator {$key1} > {$value2}";
                            $separator = ' AND ';
                            break;
                        case 'do':
                            $sql.= "$separator {$key1} < {$value2}";
                            break;
                    }

                }
            } else {
                $sql .= "$separator $key1 = $value1";
                $separator = ' AND ';
            }
        }
        return self::runSQL($sql);
    }



}