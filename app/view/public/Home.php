<?php
/**
 * Controlador del template del Inicio
 */
class Home
{
    var $layout = "home.php";

    function __construct(){
        $t = new Tova;

        $t->template( $this->layout );

        $title_site     = 'Mapper';
        $assets         = config()['host']['assets'];
        $page_title     = 'Mapper';
        $page_content   = 'Clase para procesamiento de pagos a través de bancard';

        $t->assign([
            'title_site'    => $title_site,
            'assets'        => $assets,
            'page_title'    => $page_title,
            'page_content'  => $page_content
        ]);

        $t->render();
    }

}

?>
