<?php
require_once '../../app/autoload.php';

$module = strtolower( param( 'module' ) );

$controller = new Controller( $module );

$return = $controller->save( $_POST );

if( $return > 0 ):
    $json = [ 'status' => 200, 'message' => 'Los datos se guardaron con exito.', 'type' => 'success' ]; 
else:
    $json = [ 'status' => 404, 'message' => 'Los datos no se pudieron guardar.', 'type' => 'warning' ];
endif;

setApplicationJSON();
print json_encode($json);