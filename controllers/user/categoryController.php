<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 12.08.16
 * Time: 19:18
 * @property Repository repository
 */
class categoryController
{
    private $responce;
    private $repository;


    public function __construct($command)
    {
        $this->repository = new Repository('Category');

        $arrCommand = explode('=', $command );

        switch ($arrCommand[0]) {
            case 'parent':
                $this->repository->SelectAll();
                $this->responce   = $this->repository->getList( ['name'] );
                break;
            case 'child':
                $this->repository->SelectAll();
                $this->responce   = '';
                foreach($this->repository as $key => $value ) {
                    if ($arrCommand[1] == 'v_menu') {
                        $this->responce .= "<li><a href='http://allservice.in.ua/test_task/online_store/category/id=$key'> {$value['name']} </a> </li>";

                    } else { //view
                        $this->responce .= "<div><a href='http://allservice.in.ua/test_task/online_store/category/id=$key'> {$value['name']} </a></div>";

                    }
                }
                break;
            case 'id':
                $this->responce   = 'Показ одной записи №' . $arrCommand[1];

                $value = $this->repository[$arrCommand[1]];

                $this->repository[$arrCommand[1]] = 0;

                $this->responce .= "<div> {$value['name']} </div>";

                break;

            default:
                $this->responce = 'Default from Category';
        }
    }

    public function getResponce()
    {
        return $this->responce;
    }
}