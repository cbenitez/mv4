<?php
/**
 * Controlador del template del Inicio
 */
class Index extends Tova
{
    private $layout = "index.php";

    function __construct(){    

        $this->template( $this->layout );

        $title_site     = 'Mapper';
        $assets         = config()['host']['assets'];
        $page_title     = 'Mapper';
        $page_content   = 'Clase para procesamiento de pagos a través de bancard';

        $params = '{"required":"true","name":"testInput","label":"Nombre","placeholder":"El nombre aqui"}';
        $form_control = input( $params );
        $params = '{"required":"true","name":"testInput","label":"Apellido","placeholder":"El apellido aqui"}';
        $form_control .= input( $params );
        $form_control .= input( $params );
        $params = '{"required":"true","name":"testInput","label":"Texto","placeholder":"El texto aqui","rows":"7"}';
        $form_control .= textarea( $params );
        $params = '{"required":"true","name":"testInput","help":"La ayuda aqui."}';
        $form_control .= upload( $params );

        $this->assign([
            'title_site'    => $title_site,
            'assets'        => $assets,
            'page_title'    => $page_title,
            'page_content'  => $page_content,
            'form_control'  => $form_control
        ]);

        $this->render();
    }

}

?>
