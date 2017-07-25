<?php
/**
 * Controlador del template del Inicio
 */
class Error404
{
    var $layout = "error404.php";
    var $obj;

    function __construct(){
        $controller = new Controller($this->layout);
    }

    public function init(){
    }

}

?>
