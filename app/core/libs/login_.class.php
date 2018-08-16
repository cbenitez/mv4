<?php
class Login_ extends Database {

	var $table				= "admins";
	var $fields 			= "*";
	var $conditions			= "";
	private $cookie_name	= "";
	private $cookie_expire	= "";
	private $cookie_domain	= "";
	private $cookie_secure	= "";
	private $cookie_httponly = "";
	private $list_fields	= "";

	function __construct(){
		$this->cookie_name		= config()['cookie']['name'];
		$this->cookie_expire	= config()['cookie']['expire'];
		$this->cookie_domain	= config()['cookie']['domain'];
		$this->cookie_secure	= config()['cookie']['secure'];
		$this->cookie_httponly	= config()['cookie']['httponly'];
	}

	public function set( $username, $password ){

		$prefix		= $this->table_prefix();

		$this->list_fields = $this->table_fields();

		$arr = json_decode( $this->list_fields, true );

		$user_field = "{$prefix}_email";
		$pswd_field = "{$prefix}_password";

		if( haveRows( $arr[ $this->table ][ 'fields' ] ) ):

			foreach( $arr[ $this->table ][ 'fields' ] as $fields => $field ):
				if( $field['user'] ):
					$user_field = $fields;
				endif;
				if( $field['password'] ):
					$pswd_field = $fields;
				endif;
			endforeach;

		endif;

		$username	= addslashes(strtolower(trim($username)));
		$password	= md5($password . "_" . strrev(strtoupper($username)));

		$result = $this->find( $this->table, $user_field , $username, "{$prefix}_status = 1 AND {$prefix}_hidden = 0" );

		if( is_array($result) && count($result) > 0 ):
			$result = $result[0];
			if( $result[ $pswd_field ] != $password || $result[ $prefix . '_status' ] != 1):
				$response = ['status' => 'error', 'code' => 404, 'message' => 'Usuario o clave incorrectos.'];
			else:
				foreach($result as $k => $v):
					$data[Encryption::Encrypt($k)] = Encryption::Encrypt($v);
				endforeach;
				$group_isroot = $this->find("groups", "group_id", $result['group_id'], "group_status = 1 AND group_hidden = 0");
				$data[Encryption::Encrypt('group_isroot')] = Encryption::Encrypt($group_isroot[0]['group_isroot']);
				if( !isset( $_COOKIE[ $this->cookie_name ] ) ):
					setcookie( 
						$this->cookie_name, 
						Encryption::Encrypt( json_encode( $data ) ), 
						$this->cookie_expire, 
						$this->cookie_domain, 
						$this->cookie_secure,
						$this->cookie_httponly
					);
				else:
					$_COOKIE[ $this->cookie_name ] = Encryption::Encrypt( json_encode( $data ) );
				endif;
				$response = ['status' => 'success', 'code' => 200];
			endif;
		else:
			$response = ['status' => 'error', 'code' => 404, 'message' => 'Usuario o clave incorrectos.'];
		endif;

		return $response;
	}

	public function status(){
		if(isset($_COOKIE[ $this->cookie_name ])):
			$status = $_COOKIE[ $this->cookie_name ];
			$status = count($status);
			return $status > 0 ? true : false;
		else:
			return false;
		endif;
	}

	public function close( ){
		unset( $_COOKIE[ $this->cookie_name ] );
		setcookie( 
			$this->cookie_name, 
			'', 
			time() - $this->cookie_expire
		);
	}

	public function get($var){
		
		$data = $_COOKIE[ $this->cookie_name ][Encryption::Encrypt($var)];
		return Encryption::Decrypt($data);
		
	}

	private function table_fields(){

		$json = false;
		
		if( file_exists( config()['route']['tables'] . slugit( $this->table ) . '.json' ) ):
		
			$json = file_get_contents( config()['route']['tables'] . slugit( $this->table ) . '.json' );
		
		endif;
		
		return $json;
	}

	private function table_prefix(){

		$table_fields = json_decode( $this->table_fields(), true );

		$primary_key = $table_fields[ $this->table ]['table_config']['primary_key'];

		$prefix = str_replace( '_id', '', $primary_key );

		return $prefix;
	}
}