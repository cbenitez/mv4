<?php
class Logger {
	static $log_file = "data.log";

	static function log( $log ) {
		if( config()['cache']['log'] == 'On' ):
			if( $log != '' ):
				$fh = fopen( config()['route']['log'] . self::$log_file, "a");
				fwrite($fh,date('Y-m-d H:i:s')." ".$log." ** ");
				fclose($fh);
			endif;
		endif;
	}

}