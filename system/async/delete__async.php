<?php
require_once '../../app/autoload.php';

$module = strtolower( param( 'module' ) );

$name = param( 'name' );

$pk = numParam( 'pk' );

$controller = new Controller( $module );

$r = $controller->delete( $pk );
$d = $controller->delete_image( $pk );

if( $r['code'] == 200 ):
	$json = [ 'status' => 'success', 'code' => $r['code'], 'message' => message( $r['code'], 'El registro se ha eliminado' ), 'type' => 'success', 'load' => [ 'module' => $module, 'name' => $name ],$r,$d ]; 
else:
	$json = [ 'status' => 'error', 'code' => $r['code'], 'message' => message( $r['code'], $r['description'] ), 'type' => 'warning' ];
endif;

setApplicationJSON();
print json_encode($json);