<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 05.08.16
 * Time: 19:31
 */
class adminLoginFormClass
{
   publick function Render() {
       return file_get_contents( __DIR__ . '../templates/adminLoginForm.html')
}
}