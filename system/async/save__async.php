<?php
require_once '../../app/autoload.php';

$module = strtolower( param( 'module' ) );

$controller = new Controller( $module );

$r = $controller->upload( $_FILES );

if( $r['code'] != 404 ):
	if( !isset( $_POST[ $controller->table_prefix() . '_status' ] ) ):
		$_POST[ $controller->table_prefix() . '_status' ] = 0;
	endif;
	$r = $controller->save( $_POST );
endif;
if( $r['code'] == 200 || $r['code'] == 201 ):
	$json = [ 'status' => 'success', 'code' => $r['code'], 'message' => message( $r['code'] ), 'type' => 'success','post'=> $_POST ]; 
else:
	$json = [ 'status' => 'error', 'code' => $r['code'], 'message' => message( 404, $r['description'] ), 'type' => 'warning' ];
endif;

setApplicationJSON();
print json_encode($json);