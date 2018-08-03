<?php

function message( $code, $description = "" ){
	switch ( $code ):
		case 200:
		case 201:
			$message = 'Los datos se guardaron con &eacute;xito.';
			break;
		case 400:
			$message = 'La solicitud es incorrecta.';
			break;
		case 401:
			$message = 'No tiene permisos para esta acci&oacute;n.';
			break;
		case 404:
			$message = 'Los datos no se pudieron guardar.';
			break;
		case 500:
			$message = 'Ocurri&oacute; un error al realizar esta acci&oacute;n.';
			break;
		case 510:
			$message = 'No se pudo subir el archivo al servidor.';
			break;
		default:
			$message = 'Ocurri&oacute; un error al recuperar los datos por favor verifique el log.';
			break;
	endswitch;

	if( !empty( $description ) ):
		$message = $description;
	endif;
	
	return $message;
}