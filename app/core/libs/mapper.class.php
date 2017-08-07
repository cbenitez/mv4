<?php
class Mapper extends Database{

    protected $dir_config = "app/config/tables";

    public function init(){
        $this->__config_tables();
    }

    private function __config_tables(){
        $tables = "SELECT TABLE_NAME, TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->DB_NAME . "'";
		$tables = $this->select($tables);
        if(is_array($tables) && count($tables) > 0):
            $override_tables = [
                "admins_groups",
                "admins",
                "admin_login_attempts"
            ];
			foreach($tables as $table):
				if(!in_array($table['TABLE_NAME'], $override_tables)):
					if(strlen($table['TABLE_COMMENT']) > 0):
						$table_config[ $table['TABLE_NAME'] ][ 'table_config' ] = json_decode( $table['TABLE_COMMENT'], true );
					endif;
                    $sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->DB_NAME . "' AND TABLE_NAME = '" . $table['TABLE_NAME'] ."'";
                    $columns = $sth = $this->select($sql);        
                    foreach ($columns as $column):
                        if(strlen($column['COLUMN_COMMENT']) > 0):
                            if( $column['COLUMN_KEY'] == "PRI" ):
                                $table_config[ $table['TABLE_NAME'] ][ 'table_config' ][ 'primary_key' ] = $column['COLUMN_NAME'];
                            endif;
                            $table_config[ $table['TABLE_NAME'] ][ 'fields' ][ $column['COLUMN_NAME'] ] = json_decode( $column['COLUMN_COMMENT'], true );
                        endif;
                    endforeach;
				endif;
			endforeach;
        endif;
        
        if( !is_dir( $this->dir_config ) ):
            @mkdir( $this->dir_config,0777 );
        endif;

        $this->create_file( $this->dir_config . "/config.json", json_encode( $table_config ) );

        pr($table_config);
    }

    private function create_file($filepath,$content){
    	if(!file_exists($filepath)):
			$handle = fopen($filepath , 'a');
			fwrite($handle, $content);
			fclose($handle);
			return true;
		else:
			return false;
		endif;
    }
}