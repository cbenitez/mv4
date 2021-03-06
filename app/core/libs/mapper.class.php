<?php
class Mapper extends Database{

	protected $dir_config = "app/config/tables";

	var $overwrite_files = true;

	public function init(){
		$this->__config_tables();
	}

	private function __config_tables(){

		if( !is_dir( $this->dir_config ) ):
			@mkdir( $this->dir_config,0777 );
		endif;

		$tables = "SELECT TABLE_NAME, TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->DB_NAME . "'";
		$tables = $this->select($tables);

		if(is_array($tables) && count($tables) > 0):
			$override_tables = ["admin_login_attempts"];
			$i = 0;
			foreach($tables as $table):
				if( !in_array( $table['TABLE_NAME'], $override_tables ) ):
					if( strlen( $table['TABLE_COMMENT']) > 0 ):
						$table_config[ $table['TABLE_NAME'] ][ 'table_config' ] = json_decode( utf8_encode( $table['TABLE_COMMENT'] ), true );
						$table_comment[$i] = json_decode( utf8_encode( $table['TABLE_COMMENT'] ), true );
						$table_comment[$i]['module'] = $table['TABLE_NAME'];
						$i++;
					endif;
					$sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->DB_NAME . "' AND TABLE_NAME = '" . $table['TABLE_NAME'] ."'";
					$columns = $sth = $this->select($sql);
					foreach ($columns as $column):
						if( $column['COLUMN_KEY'] == "PRI" ):
							$table_config[ $table['TABLE_NAME'] ][ 'table_config' ][ 'primary_key' ] = $column['COLUMN_NAME'];
						endif;
						if( strlen( $column['COLUMN_COMMENT'] ) > 0 ):
							$table_config[ $table['TABLE_NAME'] ][ 'fields' ][ $column['COLUMN_NAME'] ] = json_decode( utf8_encode( $column['COLUMN_COMMENT'] ), true );
						endif;
						$foreign = "SELECT REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA IS NOT NULL AND TABLE_SCHEMA = '" . $this->DB_NAME . "' AND TABLE_NAME = '" . $table['TABLE_NAME'] . "' AND REFERENCED_COLUMN_NAME = '" . $column['COLUMN_NAME'] . "';";
						$fk = $this->select($foreign);
						if(haveRows($fk)):
							$fk_table = $fk[0]['REFERENCED_TABLE_NAME'];
							$fk_field_id = $fk[0]['REFERENCED_COLUMN_NAME'];
							$table_config[ $table['TABLE_NAME'] ][ 'fields' ][ $column['COLUMN_NAME'] ][ 'fk_table' ] 		= $fk_table;
							$table_config[ $table['TABLE_NAME'] ][ 'fields' ][ $column['COLUMN_NAME'] ][ 'fk_field_id' ]	= $fk_field_id;
						endif;
					endforeach;
					$this->generate_config_file( $this->dir_config . "/" . slugit( $table['TABLE_NAME'] ) . ".json", json_encode( $table_config, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE ) );
					unset( $table_config );
				endif;
			endforeach;
			$menu_config = $table_comment;
			$this->generate_config_file( $this->dir_config . "/menu_config.json", json_encode( $menu_config, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE ) );
			unset( $menu_config );
		endif;

	}

	private function generate_config_file( $filepath, $content ){
		if( $this->overwrite_files && file_exists( $filepath )):
			$resource = $this->create_file( $filepath, $content );
			if( is_file( $filepath ) ):
				print "Se ha sobreescrito: {$resource}\n\n";
			else:
				print "No se ha podido sobreescribir: {$resource}\n\n";
			endif;
		else:
			if( !file_exists( $filepath ) ):
				$resource = $this->create_file( $filepath, $content );
				if( is_file( $filepath ) ):
					print "Se ha creado: {$resource}\n\n";
				else:
					print "No se ha podido crear: {$resource}\n\n";
				endif;
			else:
				print "No se ha podido crear o sobreescribir: {$resource}\n\n";
			endif;
		endif;
	}

	private function create_file( $filepath, $content ){
		$handle = fopen( $filepath , 'w' );
		fwrite( $handle, $content );
		fclose( $handle );
		$name = end( explode( "/", $filepath ) );
		return $name;
	}
}