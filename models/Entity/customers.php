<?php
class Customers{
    private $id;
    private $name;
    private $adress;
    
    static private $conn;

    public function __construct()
    {
    }

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
     * поиск клиента по адресу
     * @param $adress
     * @return bool|mysqli_result
     */
    public function fromAdress($adress){
        $sql = "select * from customers where address = {$adress}";
        return self::runSQL($sql);
    }

    /**
     * поиск клиента по имени
     * @param $name
     * @return bool|mysqli_result
     */
    public function fromName($name){
        $sql = "select * from customers where name = {$name}";
        return self::runSQL($sql);
    }

    /**
     * количество клиентов
     * @return mixed
     */
    
    static public function CountRecord()
    {
        $sql = 'select count(*) from customers ';
        $result = self::runSQL($sql);
        $row = mysqli_fetch_assoc($result);
        return $row[0];
    }

    static public function getIDs()
    {
        $sql = "select id from customers ";
        $result = self::runSQL($sql);
        $arrResult = [];
        while( $row = mysqli_fetch_array($result))
        {
            $arrResult[] = $row[0];
        }
        return $arrResult;
    }
    /**
     * Все записи из табл клиентов
     * @return bool|mysqli_result
     */
    static public function SelectAll()
    {
        $sql = "select * from customers ";
        return self::runSQL($sql);

    }

    /**
     * запись по идентификатору клиента $id
     * @param $id
     * @return bool|mysqli_result
     */
    public function fromID($id){
        $sql = "select * from customers where id = {$id}";
        return self::runSQL($sql);
    }


    /**
     * отбор записей по условиям в массиве $arrSearch
     *  fromBY( [ 'name' => 'Dmitro', 'address' => [ 'ot' => 'Bruclin', 'do' => 'Moskau' ] ])
     * @param array $arrSearch
     * @return bool|mysqli_result
     */
    static public function fromBy(array $arrSerch){
        $sql = "select * from customers where ";
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