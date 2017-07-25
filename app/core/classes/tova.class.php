<?php
class Tova
{
    const Version = '0.2.20170724';

    var $resource;
    
    var $layout_dir =__DIR__ . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR;

    var $cache_file_ext = ".tmp";

    var $template_caching = true;

    var $template_cache_file = false;

    var $template_cache_dir = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;

    var $template_cache_ttl = 300; // secs

    var $include_dir = "";

    var $params = [];

    function __construct(){
        $this->layout_dir           = config()['route']['layout'];
        $this->include_dir          = config()['route']['includes'];
        $this->template_cache_dir   = config()['route']['template'];
    }

    public function template( $resource ){
        $this->resource = $resource;
        $this->template_cache_file = $this->template_cache_dir . $this->resource . $this->cache_file_ext;
    }

    public function assign( $params ){
        if ( !is_array( $params ) ){
            return;
        }
        foreach ( $params as $name => $data ){
            $this->add($name, $data);
        }
        return;        
    }

    public function render( $return = false ){
        $file = $this->layout_dir . $this->resource;
        
        if( !file_exists( $file ) ):
            die('Error el template "'. $this->resource .'" no existe!');
        endif;

        $reader = file_get_contents( $file );

        $render = preg_replace_callback( "#{{(.*)}}#isU", "self::find", $reader );
        $render = $this->PHP_tag_parse( $render );
        $render = $this->If_tag_parse( $render );
        $render = $this->For_tag_parse( $render );
        $render = preg_replace_callback( "#{% (.*) (.*) %}#isU", "self::tag", $render );

        if( $this->template_caching ):
            try {
                $get_template = $this->get_template();
                if( $get_template ):
                    $content = @eval('?>'.$get_template.'<?php ?>');
                else:
                    $this->set_template( $render );
                    $content = @eval('?>'.$render.'<?php ?>');
                endif;
                return $content;
            }catch( Exception $e){
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            };
        else:
            if( $return ):
                return $render;
            else:
                try {
                    return @eval('?>'.$render.'<?php ?>');
                }catch( Exception $e){
                    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                };
            endif;
        endif;
    }

    private function find( $find ){
        return $this->params[ $find[1] ];
    }

    private function add($var_name, $var_data){
        $this->params[$var_name] = $var_data;
    }

    private function tag( $tag ){
        switch ( $tag[1] ):
            case 'include':
                if( file_exists( $this->include_dir . $tag[2] ) ):
                    $reader = file_get_contents( $this->include_dir . $tag[2] );
                    $render = preg_replace_callback( "#{{(.*)}}#isU", "self::find", $reader );
                    $render = $this->PHP_tag_parse( $render );
                    $render = $this->If_tag_parse( $render );
                    $render = $this->For_tag_parse( $render );
                endif;
            break;
            case 'include_file':
                if( file_exists( $tag[2] ) ):
                    $reader = file_get_contents( $tag[2] );
                    $render = preg_replace_callback( "#{{(.*)}}#isU", "self::find", $reader );
                endif;
            break;
        endswitch;

        return $render;
    }

    private function PHP_tag_parse( $code ){
        $code = str_replace('[php]', '<?php', $code);
        $code = str_replace('[/php]', '?>', $code);
        return $code;
    }

    private function If_tag_parse( $code ){
        $code = str_replace('{else}', '<?php } else { ?>', $code);
        $code = str_replace('{/if}', '<?php } ?>', $code);
        $code = preg_replace('/\{if:(.+?) \}/i', '<?php if( $1 ){ ?>', $code);
        return $code;
    }

    private function For_tag_parse( $code ){
        $code = str_replace('{/for}', '<?php } ?>', $code);
        $code = preg_replace('/\{for: (.*) in (.*) \}/i', '<?php $$2 = $this->params[ \'$2\' ]; foreach( $$2 as $$1 ){ ?>', $code);
        $code = preg_replace("#{:(.+?)[.](.+?)}#i", '<?php echo $$1[\'$2\']; ?>', $code);
        return $code;
    }

    static public function merge($templates, $separator = "n") {
        $output = "";
    
        foreach ($templates as $template):
            $content = (get_class($template) !== "Tova")
                ? "Error, incorrect type - expected Tova."
                : $template->render();
            $output .= $content . $separator;
        endforeach;
    
        return $output;
    }

    private function set_template( $content ) {;
        // save template
        Logger::log( "Caching template " . $this->resource );
        $fh = fopen( $this->template_cache_file, 'w' );
        fwrite( $fh, $content );
        fclose( $fh );
        // Flush the output buffer and turn off output buffering
        ob_end_flush();
    }

    private function get_template() {
        // check if a cached template exists
        if( file_exists( $this->template_cache_file ) ):
            if( time() - filemtime( $this->template_cache_file ) < $this->template_cache_ttl ):
                Logger::log( "Cache hit for template " . $this->template_name );
                $content = file_get_contents( $this->template_cache_file );
                return $content;
            else:
                Logger::log("Cache stale for template " . $this->template_name );
                return false;
            endif;
        else:
            Logger::log( "Cache miss for template " . $this->template_name );
            return false;
        endif;
    }
}