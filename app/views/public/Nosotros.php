<?php
/**
 * Controlador del template del Inicio
 */
class Nosotros
{
    var $layout = "nosotros.php";

    function __construct(){
        $t = new Tova;

        $t->template( $this->layout );

        $title_site     = 'Mapper :: Nosotros';
        $assets         = config()['host']['assets'];
        $page_title     = 'Nosotros';
        $page_content   = 'Aca el texto de nosotros';

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
