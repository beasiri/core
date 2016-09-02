<?php
class Orders{

    private $id;
    private $numberOrder;
    private $summ;
    private $idCustomer;
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
     * получение заказа id
     * @param $id
     * @return bool|mysqli_result
     */
    public function fromID($id){
        $sql = "select * from orders where id = {$id}";
        return self::runSQL($sql);
    }
    
    /**
     * получить количество заказов
     * @return mixed
     */
    static public function CountRecord()
    {
        $sql = 'select count(*) from orders ';
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
     * получить все накладные с деталями: номер, сумма, покупатель
     * @return bool|mysqli_result
     */
    static public function SelectAll()
    {
        $sql = "select numberOrder, summ, idCustomer from orders ";
        return self::runSQL($sql);

    }

    /**
     * отбор записей по условиям в массиве $arrSearch
     *  fromBY( [ 'numberOrder' => '587487', 'summ' => [ 'ot' => '100', 'do' => '200' ] ])
     * @param array $arrSearch
     * @return bool|mysqli_result
     */
    static public function fromBy(array $arrSerch){
        $sql = "select * from orders where ";
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