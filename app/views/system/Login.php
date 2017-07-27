<?php
/**
 * Controlador del template del Inicio
 */
class Login extends Tova
{
    private $layout = "login.html";

    function __construct(){

        $this->layout_dir           = config()['route']['sys_layout'];
        $this->include_dir          = config()['route']['sys_inc'];
        $this->template( $this->layout );

        $project_name   = config()['project_name'];
        $title_site     = 'Login';
        $assets         = config()['host']['sys_assets'];

        $this->assign([
            'project_name'  => $project_name,
            'title_site'    => $title_site,
            'assets'        => $assets
        ]);

        $this->render();
    }

}

?>