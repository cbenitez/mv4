<?php
require_once '../../app/autoload.php';

$task   = param( 'task' );
$pk     = numParam( 'pk' );
$module = strtolower( param( 'module' ) );
$name   = strtolower( param( 'name' ) );
$controller = new Controller( $module );
if( $pk > 0 ):
    $subtit = "Modificar";
else:
    $subtit = "Nuevo";
endif;
switch( $task ):
    case 'form':

        /*
        * Boton volver
        */
        $result .= '<div class="row">';
        $result .= ' <div class="col-md-12 text-right">';
        $result .= '    <button class="btn btn-outline-primary" type="button" onclick="mapperJs.list(\'' . $module . '\',\'' . $name . '\')"><i class="fa fa-arrow-left"></i> Volver</button>';
        $result .= ' </div>';
        $result .= '</div>';

        /*
         * Formulario del modulo
         */
        $result .= '<form action="" method="post" enctype="multipart/form-data" onsubmit="mapperJs.save(\'' . $module . '\',\'' . $name . '\');return false;">';
        $result .=      $controller->form_construct( $pk );
        $result .= '<div class="well">';
        $result .= '    <button class="btn btn-outline-danger" type="button" onclick="mapperJs.list(\'' . $module . '\',\'' . $name . '\')"><i class="fa fa-times"></i> Cancelar</button>';
        $result .= '    <button class="btn btn-outline-success" type="submit"><i class="fa fa-save"></i> Guardar</button>';
        $result .= '</div>';
        $result .= '</form>';

        $json = [ 'status' => 'success', 'code' => 200, 'title' => ucfirst( $name . ' > ' . $subtit ), 'result' => $result ];
    break;
    default:
        $json = [ 'status' => 'error', 'code' => 404, 'message' => 'Ocurrio un error no se recibieron todos los datos.', 'type' => 'danger' ];
endswitch;

setApplicationJSON();
print json_encode( $json );