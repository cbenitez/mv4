<?php

class Encryption{
	
	public static function Encrypt($value){

		$key = config()['authToken'];

		$encType = MCRYPT_RIJNDAEL_256;
		$encMode = MCRYPT_MODE_ECB;
		$return  = mcrypt_encrypt($encType, $key, $value, $encMode, mcrypt_create_iv(mcrypt_get_iv_size($encType, $encMode), MCRYPT_RAND));
		$return  = strrev($return);
		return rtrim( strtr( base64_encode( $return ), '+/', '-_'), '=');

	}

	public static function Decrypt($value){

		$key = config()['authToken'];

		$value	 = base64_decode( strtr( $value, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen( $value ) ) % 4 ) ); 
		$value	 = strrev($value);

		$encType = MCRYPT_RIJNDAEL_256;
		$encMode = MCRYPT_MODE_ECB;
		$return  = mcrypt_decrypt($encType, $key, $value, $encMode, mcrypt_create_iv(mcrypt_get_iv_size($encType, $encMode), MCRYPT_RAND));

		return trim($return);

	}
}

?>
