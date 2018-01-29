<?php

class Model extends Database {

    var $table;
    var $primary_key;
    var $fields = "*";

    function __contruct(){

    }

    public function action_create( $data ){
        $last_id = $this->insert( $this->table, json_decode( $data, true ) );
        return $last_id;
    }

    public function action_update( $data ){
        $data = json_decode( $data, true );
        $this->update( $this->table, $data, "{$this->primary_key} = {$data[$this->primary_key]}" );
        return $data[ $this->primary_key ];
    }

    public function action_delete( $data ){
        $data = json_decode( $data, true );
        $d = $this->delete( $this->table, "`".$this->primary_key."` = {$data[$this->primary_key]}" );
        if( $d ):
            $result = $data[ $this->primary_key ];
        else:
            $result = 0;
        endif;
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
            endif;
        endif;
        $list = $this->select( "SELECT {$this->fields} FROM {$this->table} {$conditions}" );
        Logger::log("SELECT: SELECT {$this->fields} FROM {$this->table} {$conditions}, params= ".json_encode( $params, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE )." && list= ".json_encode( $list, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE )." \n\r");
        return json_encode( $list, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE );
    }

}