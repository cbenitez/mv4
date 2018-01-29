<?php
/**
 * Controlador del template del Inicio
 */
class Dashboard extends Tova
{
    private $layout = "dashboard.html";

    function __construct(){

        $this->layout_dir           = config()['route']['sys_layout'];
        $this->include_dir          = config()['route']['sys_inc'];
        $this->template( $this->layout );

        $title_site     = 'Dashboard';
        $project_name   = config()['project_name'];
        $assets         = config()['host']['sys_assets'];
        $url            = config()['host']['app'];
        $app            = config()['host']['app'];
        $section_title  = '';

        $this->assign([
            'project_name'  => $project_name,
            'title_site'    => $title_site,
            'assets'        => $assets,
            'section_title' => $section_title,
            'app'           => $app,
            'url'           => $url
        ]);
        
        $menu_config['menu_config'] = config()['menu_config'];
        $this->assign( $menu_config );

        $this->render();
    }

}

?>
