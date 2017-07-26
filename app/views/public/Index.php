<?php
/**
 * Controlador del template del Inicio
 */
class Index extends Tova
{
    var $layout = "index.php";

    function __construct(){
        parent::__construct();
        $this->template( $this->layout );

        $title_site     = 'Mapper';
        $assets         = config()['host']['assets'];
        $page_title     = 'Mapper';
        $page_content   = 'Clase para procesamiento de pagos a través de bancard';

        $this->assign([
            'title_site'    => $title_site,
            'assets'        => $assets,
            'page_title'    => $page_title,
            'page_content'  => $page_content
        ]);

        $this->render();
    }

}

?>
