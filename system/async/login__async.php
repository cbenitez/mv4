<?php
require_once '../../app/autoload.php';

$username	= param('input_user');
$password	= param('input_password');
$token		= param('input_token');
$token		= Encryption::Decrypt( $token );

$login	= new Login_;

switch ( $token ):
	case 'login_adm':
		$json = $login->set( $username, $password );
		break;
	default:
		$json = ['status' => 'error', 'code' => 400, 'message' => 'Los par&aacute;metros recibidos no son correctos'];
endswitch;

setApplicationJSON();
print json_encode( $json );