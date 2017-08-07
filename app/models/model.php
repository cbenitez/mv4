<?php

class Model extends Database {

    var $table;
    var $primary_key;
    var $fields = "*";

    function __contruct(){

    }

    public function action_create( $data ){
        $last_id = $this->insert( $this->table, json_decode( $data, true ) );
        $result = [ $this->primary_key => $last_id ];
        return json_encode( $result, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE );
    }

    public function action_update( $data ){
        $data = json_decode( $data, true );
        $this->update( $this->table, $data, "{$this->primary_key} = {$data[$this->primary_key]}" );
        $result = [ $this->primary_key => $data[$this->primary_key] ];
        return json_encode( $result, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE );
    }

    public function action_delete( $data ){
        $data = json_decode( $data, true );
        $d = $this->delete( $this->table, "`".$this->primary_key."` = {$data[$this->primary_key]}" );
        if( $d ):
            $result = [ $this->primary_key => $data[$this->primary_key] ];
        else:
            $result = [ $this->primary_key => 0 ];
        endif;
        return json_encode( $result, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE );
    }

    public function action_select( ){
        $list = $this->select( "SELECT {$this->fields} FROM {$this->table}" );
        return json_encode( $list, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE );
    }

    public function action_fields( ){
        $columns = $this->get_fields( $this->table );
        if( count( $columns ) > 0 && is_array( $list_fields ) ):
            foreach ($columns as $column):
                if(strlen($column['COLUMN_COMMENT']) > 0):
                    $column_config = @json_decode( utf8_encode( $column['COLUMN_COMMENT'] ) );
                    if($column_config instanceof stdClass):
                        
                    endif;
                endif;
            endforeach;
        endif;
        return json_encode( $list_fields, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE );
    }
}