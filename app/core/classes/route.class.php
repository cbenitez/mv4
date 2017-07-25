<?php
/**
 * By Christian Benitez
 */
class Route{

    private $_uri = array();
    private $_method = array();

    function __construct(){

    }

    public function add( $uri, $method = null ){
        $this->_uri[] = $uri;
        if( $method != null ):
            $this->_method[] = $method;
        endif;
    }

    public function submit(){

        $uriRequestParam = isset( $_REQUEST['uri'] ) ? '/' . $_REQUEST['uri'] : '/';

        foreach( $this->_uri as $key => $value ):
            if( preg_match("#^$value$#",$uriRequestParam) ):
                if( is_string($this->_method[$key]) ):
                    $useMethod = $this->_method[$key];
                    new $useMethod();
                else:
                    call_user_func($this->_method[$key]);
                endif;
            endif;
        endforeach;
    }
}
