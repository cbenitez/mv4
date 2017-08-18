<?php
class Controller{
    
    protected $list_fields = '';

    function __construct( $table ){
        $this->table = $table;
    }

    public function save( $id ){

    }

    public function edit( $id ){
        
    }

    public function list( $params = "" ){
        $obj = new Model;
        $obj->table = $this->table;
        $result = $obj->action_select( $params );
        return $result;
    }

    public function form_construct( $pk = 0 ){
        $this->list_fields = $this->table_fields();
        $form = '';
        $arr = json_decode( $this->list_fields, true );
        if( $pk > 0 ):
            $list = json_decode( $this->list( '{"where":" ' . $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] . ' = ' . $pk . '"}' ), true );  
            $form .= '<input type="hidden" name="' . $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] . '" value="'.$pk.'">';          
        endif;
        if( is_array( $arr[ $this->table ][ 'fields' ] ) ):
            foreach( $arr[ $this->table ][ 'fields' ] as $fields => $field ):
                if( is_array( $list ) ):
                    $field['val'] = $list[0][ $fields ];
                endif;
                switch( $field[ 'type' ] ):
                    case 'password':
                    case 'datetime':
                    case 'datetime-local':
                    case 'date': 
                    case 'month':
                    case 'time': 
                    case 'week': 
                    case 'number':
                    case 'email': 
                    case 'url': 
                    case 'search':
                    case 'tel': 
                    case 'color':
                    case 'text': 
                        $form .= input( $field );
                    break;
                    case 'textarea':
                        $form .= textarea( $field );
                    break;
                    case 'select':
                        $form .= select( $field );
                    break;
                    case 'upload':
                        $form .= upload( $field );
                    break;
                    case 'checkbox':
                        $form .= check_radio( $field );
                    break;
                    case 'radio':
                        $form .= check_radio( $field );
                    break;
                endswitch;
            endforeach;
        endif;
        return $form;
    }

    public function table_fields(){
        $json = false;
        if( file_exists( config()['route']['tables'] . slugit( $this->table ) . '.json' ) ):
            $json = file_get_contents( config()['route']['tables'] . slugit( $this->table ) . '.json' );
        endif;
        return $json;
    }

}
