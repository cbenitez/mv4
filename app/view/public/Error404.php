<?php
/**
 * Controlador del template del Inicio
 */
class Error404
{
    var $layout = "error404.php";

    function __construct(){
        $t = new Tova;

        $t->template( $this->layout );

        $t->render();   
    }

}

?>
