<?php
/**
 * Controlador del template del Inicio
 */
class Dashboard
{
    var $layout = "dashboard.html";
    var $obj;

    function __construct(){
        $t = new Tova;

        $t->layout_dir           = config()['route']['sys_layout'];
        $t->include_dir          = config()['route']['sys_inc'];
        $t->template( $this->layout );

        $title_site     = 'Dashboard';
        $project_name   = config()['project_name'];
        $assets         = config()['host']['sys_assets'];
        $section_title  = 'Section title';

        $t->assign([
            'project_name'  => $project_name,
            'title_site'    => $title_site,
            'assets'        => $assets,
            'section_title' => $section_title
        ]);

        $t->render();
    }

}

?>
