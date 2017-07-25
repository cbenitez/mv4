<?php
/**
 * Controlador del template del Inicio
 */
class Dashboard
{
    var $layout = "dashboard.php";
    var $obj;

    function __construct(){
        $t = new Tova;

        $t->layout_dir           = config()['route']['systeml'];
        $t->include_dir          = config()['route']['systeminc'];
        $t->template( $this->layout );

        $title_site     = 'Mapper :: Dashboard';
        $assets         = config()['host']['site'].'dashboard/assets/';
        $page_title     = 'Dashboard';
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
