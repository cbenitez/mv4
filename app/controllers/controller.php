<?php
class Controller extends Model{
    
    protected $list_fields = '';

    function __construct( $table ){
        $this->table = $table;
    }

    public function save( $id ){

    }

    public function edit( $id ){
        
    }

    public function list( $params ){

    }

    public function form_construct(){

    }

    private function table_fields(){
        return include( config()['route']['tables'] . slugit( $this->table ) . '.json' );
    }

}
