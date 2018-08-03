<?php

class Model extends Database {

	var $table;
	var $primary_key;
	var $fields = "*";

	function __contruct(){

	}

	public function action_create( $data ){
		$result = $this->insert( $this->table, json_decode( $data, true ) );
		Logger::log( "INSERT: {$this->table} VALUES {$data}  \n\r" );
		$code = number( $result ) > 0 ? 201 : 404;
		return ['code' => $code, 'description'=> $result];
	}

	public function action_update( $data ){
		$data_log = $data;
		$data = json_decode( $data, true );
		$result = $this->update( $this->table, $data, "{$this->primary_key} = {$data[$this->primary_key]}" );
		Logger::log( "UPDATE: {$this->table} {$data_log} WHERE {$this->primary_key} = {$data[$this->primary_key]} \n\r" );
		return ['code' => 200, 'description'=> $result];
	}

	public function action_delete( $pk ){
		$d = $this->delete( $this->table, "{$this->primary_key} = {$pk}" );
		Logger::log( "DELETE: ".$this->table. " {$this->primary_key} = {$pk}  \n\r" );
		$result['code'] =  $d ? 200 : 400;
		return $result;
	}

	public function action_select( $params = "" ){
		$conditions = "";
		if( !empty( $params ) ):
			if( isJSON( $params ) ):
				$params = json_decode( $params, true );
				if( is_array( $params ) ):
					foreach( $params as $n => $x ):
						$conditions .= "{$n} {$x} ";
					endforeach;
				endif;
			else:
				$conditions = 'Error parse json! ' . $params;
			endif;
		endif;
		$list = $this->select( "SELECT {$this->fields} FROM {$this->table} {$conditions}" );
		Logger::log("SELECT: SELECT {$this->fields} FROM {$this->table} {$conditions}, params= ".json_encode( $params, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE )." && list= ".json_encode( $list, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE )." \n\r");
		return json_encode( $list, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE );
	}

}