<?php
class Controller{
	
	protected $list_fields 	= '';
	private $page_number 	= 1;
	private $config;
	private $model;

	function __construct( $table ){
		$this->table 	= $table;
		$this->config	= config();
		$this->model	= new Model;
	}

	public function save( $data ){

		$this->model->table = $this->table;

		$this->list_fields = $this->table_fields();

		$arr = json_decode( $this->list_fields, true );

		$exist = json_decode( $this->model->action_select( '{"where":" ' . $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] . ' = ' . number( $data[ $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] ] ) . '"}' ), true );

		if( count( $exist ) == 0 ):

			unset( $data[ $arr[$this->table]['table_config']['primary_key'] ] );

			$result = $this->model->action_create( json_encode( $data ) );

		else:

			$this->model->primary_key = $arr[$this->table]['table_config']['primary_key'];

			$result = $this->model->action_update( json_encode( $data ) );

		endif;

		return $result;
	}

	public function delete( $pk ){

		$this->model->table = $this->table;

		$this->list_fields = $this->table_fields();

		$arr = json_decode( $this->list_fields, true );

		$this->model->primary_key = $arr[$this->table]['table_config']['primary_key'];

		$result = $this->model->action_delete( $pk );
		
		return $result;
	}

	public function list( $params = "" ){

		$this->model->table = $this->table;
		
		$list = $this->model->action_select( $params );
		
		return $list;
	}

	public function pagination ( $params ){

		extract( json_decode( $params, true ), EXTR_OVERWRITE );

		$this->model->table = $this->table;
		
		if( is_numeric ( $limit ) ):

			$starting = number( $page ) - 1 * $limit;

		endif;

		if ( $starting > 0 ):

			$limiting = '"limit":"' . $starting . ', ' . $limit .'"';

		else:
			
			$limiting = '"limit":"0, 9"';
			
		endif;

		if( isset( $where ) ):

			$where = '"where":"'.$where.'",';

		endif;

		if( isset( $order ) ):

			$order = '"order by":"'.$order.'", ';

		endif;

		$params = '{' . $where . $order . $limiting . '}';

		$list = $this->model->action_select( $params );

		$result['list'] = json_decode( $list, true );
		
		if( $limit > 0 ):

			$result['navigation'] =	pagination( count( $result['list'] ), $page );
		
		else:

			$result['navigation'] = '';

		endif;

		return $result;
	}

	public function upload( $files ){

		$this->list_fields = $this->table_fields();

		$arr = json_decode( $this->list_fields, true );

		$prefix = str_replace( '_id', '', $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] );

		if( !array_key_exists( $prefix . '_file_name', $arr[ $this->table ][ 'fields' ] ) ) :
			return;
		endif;

		if(strlen($files[$prefix . '_file_name']['name']) > 0):

			if($files[$prefix . '_file_name']['error'] == 0):

				if( !is_dir( $this->config['route']['upload'] . $this->table ) ):
					@mkdir( $this->config['route']['upload'] . $this->table, 0777 );
				endif;

				$sourceName	 = $files[$prefix . '_file_name']['name'];
				$sourceImage = $files[$prefix . '_file_name']['tmp_name'];
				$targetImage = strtoupper(uniqid(randomnumbers(6,8).'_'.randomnumbers(6,8).'_'));
				$size = getimagesize($sourceImage);
				//$size_w = $size[0]; // width
				//$size_h = $size[1]; // height

				$size_w = 600; // width
				$size_h = 600; // height

				/* sube la foto */
				$img = new ImageUpload();
				$img->setOutputFormat("JPG");
				$img->fileToResize($sourceImage);
				$img->setAlignment("center");
				$img->setBackgroundColor(array(255, 255, 255));

				$img->setOutputFile($targetImage . "_B");
				$img->setTarget($this->config['route']['upload'] . $this->table . "/");
				$img->setSize($size_w,$size_h);
				$img->Resize();
				$file_large = $img->getOutputFileName();

				$img->setOutputFile($targetImage . "_S");
				$img->setSize(150,150);
				$img->Resize();
				$file_small = $img->getOutputFileName();

				$_POST[ $prefix . '_file_name' ]	= $sourceName;
				$_POST[ $prefix . '_big_path' ]		= $this->config['route']['upload'] . $this->table . "/" . $file_large;
				$_POST[ $prefix . '_big_url' ]		= $this->config['host']['upload']  . $this->table . "/" . $file_large;
				$_POST[ $prefix . '_small_path' ]	= $this->config['route']['upload'] . $this->table . "/" . $file_small;
				$_POST[ $prefix . '_small_url' ]	= $this->config['host']['upload']  . $this->table . "/" . $file_small;

				return $_POST;

			else:
				return ['code' => 404, 'description' => 'Ocurri&oacute; un error al subir la imagen'];
			endif;

		else:
			return ['code' => 404, 'description' => 'Debe subir una imagen.'];
		endif;
	}

	public function delete_image( $pk ){

		$this->list_fields = $this->table_fields();

		$arr = json_decode( $this->list_fields, true );

		$prefix = str_replace( '_id', '', $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] );

		if( !array_key_exists( $prefix . '_file_name', $arr[ $this->table ][ 'fields' ] ) ) :
			return;
		endif;

		$params = '{"where":"' . $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] . '=' . $pk . '"}';
		$list = json_decode( $this->list( $params ), true );

		@unlink( $list[0][ $prefix . '_big_path' ] );
		@unlink( $list[0][ $prefix . '_small_path' ] );
	}

	public function form_construct( $pk = 0 ){

		$this->list_fields = $this->table_fields();

		$form = '';
		
		$arr = json_decode( $this->list_fields, true );

		if( $pk > 0 ):
		
			$list = json_decode( $this->list( '{"where":" ' . $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] . ' = ' . $pk . '"}' ), true );
		
			$form .= '<input type="hidden" name="' . $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] . '" value="' . $pk . '">';

		else:
		
			$form .= '<input type="hidden" name="' . $arr[ $this->table ][ 'table_config' ][ 'primary_key' ] . '" value="0">';

		endif;
		
		if( is_array( $arr[ $this->table ][ 'fields' ] ) ):
		
			foreach( $arr[ $this->table ][ 'fields' ] as $fields => $field ):
		
				if( is_array( $list ) && count( $list ) > 0 ):
		
					$field['val'] = $list[0][ $fields ];

				endif;
		
				$field['name'] = $fields;

				switch( $field[ 'type' ] ):
					case 'password': case 'datetime': case 'datetime-local': case 'date': case 'month': case 'time': case 'week': case 'number': case 'email': case 'url': case 'search': case 'tel': case 'color': case 'text': 
						$form .= input( $field );
					break;
					case 'textarea':
						$form .= textarea( $field );
					break;
					case 'select':
						$form .= select( $field );
					break;
					case 'upload':
					case 'image':
						if( !is_dir( config()['route']['upload'] . $this->table ) ):
							@mkdir( config()['route']['upload'] . $this->table, 0777 );
						endif;
						$form .= upload( $field );
						if( !is_dir( config()['route']['upload'] . $this->table ) ):
							$form .= '
							<div class="alert alert-danger" role="alert">
								No se ha podido crear la carpeta <strong>' . config()['route']['upload'] . $this->table . '</strong> en upload.<br>
								Verifique los permisos antes de continuar.
							</div>';
						endif;
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

	public function table_prefix(){

		$table_fields = json_decode( $this->table_fields(), true );

		$primary_key = $table_fields[ $this->table ]['table_config']['primary_key'];

		$prefix = str_replace( '_id', '', $primary_key );

		return $prefix;
	}

}
