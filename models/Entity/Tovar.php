<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.08.2016
 * Time: 19:41
 */
class Tovar
{
    // primary key, autoincrement
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;
    // integer, link by primary key parent category
    private $idCategory;
    private $price;
    private $availability;
    private $idView;

    static private $conn;

    public function __construct($name, $parentId = 0)
    {
        $this->name = $name;
        $this->parentId = $parentId;
        self::$conn = mysqli_connect();

    }

    static public function runSQL($sql)
    {
        $result = mysqli_query( self::$conn, $sql );

        return $result;
    }
    static public function SelectAll()
    {
        $sql = 'select * from category ';

        return self::runSQL($sql);

    }
    public function fromID($id)
    {
        $sql = 'select * from category where id = ?';

        return self::runSQL($sql);
    }

    public function fromName($name)
    {
        $sql = 'select * from category where name = ?';

        return self::runSQL($sql);
    }

    /**
     *  fromBY( [ 'name' => 'Dmitro', 'address' => [ 'ot' => 'Bruclin', 'do' => 'Moskau' ] ])
     * @param array $arrSearch
     * @return bool|mysqli_result
     */
    public function fromBy(array $arrSearch)
    {
        $sql = 'select * from category where ';
        $separator = '';

        foreach ($arrSearch as $key => $value) {
            if (is_array($value) ) {
                foreach ($value as $key => $arrow) {
                    switch ($key) {
                        case 'ot':
                            $sql .= "$separator $key < $value";
                    }
                }
            }
            else
                $sql .= "$separator $key = $value";
            $separator = ' AND ';
        }

        return self::runSQL($sql);
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}