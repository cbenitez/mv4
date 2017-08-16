<?php
require_once '../../app/autoload.php';

$task = param( 'task' );
$module = strtolower( param( 'module' ) );

switch( $task ):
    case 'form':
        /*
         * Miga de pan
         */
        $result = '<ol class="breadcrumb">';
        $result .= '<li><a href="./">Dashboard</a></li>';
        $result .= '<li class="active">' . ucfirst( $module ) . '</li>';
        $result .= '</ol>';

        /*
         * Titulo del modulo
         */
        $result .= '<h2>' . ucfirst( $module ) . '</h2>';

        /*
         * Formulario de busqueda
         */
        $result .= '<form action="" method="post" enctype="multipart/form-data">';
        $result .= ' <div class="form-group">';
        $result .= '     <div class="input-group">';
        $result .= '         <input type="text" class="form-control" id="search" placeholder="Escriba aqui para filtrar...">';
        $result .= '         <div class="input-group-btn">';
        $result .= '             <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>';
        $result .= '         </div>';
        $result .= '     </div>';
        $result .= ' </div>';
        $result .= '</form>';
        
        /*
         * Boton para nuevo registro
         */
        $result .= '<div class="row">';
        $result .= ' <div class="col-md-2 col-md-offset-10 text-right">';
        $result .= '     <button class="btn btn-success" type="button"><i class="fa fa-plus-circle"></i> Nuevo registro</button>';
        $result .= ' </div>';
        $result .= '</div>';

        $json = [ 'status' => 200, 'result' => $result ];
    break;
    default:
        $json = [ 'status' => 404, 'message' => 'Ocurrio un error no se recibieron todos los datos.', 'type' => 'danger' ];
endswitch;

setApplicationJSON();
print json_encode( $json );