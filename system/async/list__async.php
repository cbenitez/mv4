<?php
require_once '../../app/autoload.php';

$task   =  param( 'task' );
$module =  strtolower( param( 'module' ) );
$name   =  strtolower( param( 'name' ) );
$page   =  numParam( 'page' );
$limit  =  numParam( 'limit' );
$search =  param( 'search' );

switch( $task ):
	case 'list':
		/*
		 * Formulario de busqueda
		 */
		$result .= '<form action="" method="post" enctype="text/plain" onsubmit="mapperJs.list(\''.$module.'\',\''.$name.'\');return false;">';
		$result .= ' <div class="form-group">';
		$result .= '     <div class="input-group">';
		$result .= '         <input type="text" class="form-control" name="search" id="search" placeholder="Escriba aqui para filtrar..." value="'.$search.'">';
		$result .= '         <div class="input-group-btn">';
		$result .= '             <button class="btn btn-default" type="submit"><i data-feather="search"></i></button>';
		$result .= '         </div>';
		$result .= '     </div>';
		$result .= ' </div>';
		$result .= '</form>';

		/*
		 * Boton para nuevo registro
		 $result .= '<div class="row">';
		 $result .= ' <div class="col-md-12 text-right">';
		 $result .= '     <button class="btn btn-success" type="button" onclick="mapperJs.action(\''.$module.'\',\''.$name.'\',\'form\',0);"><i class="fa fa-plus-circle"></i> Nuevo registro</button>';
		 $result .= ' </div>';
		 $result .= '</div>';
		*/
		
		/*
		 * Lista de registros dinamica
		 */
		$controller = new Controller( $module );
		
		$list_fields = $controller->table_fields();

		$arr = json_decode( $list_fields, true );

		$prefix = str_replace( '_id', '', $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] );

		if( haveRows( $arr[ $controller->table ][ 'fields' ] ) ):

			$result .= '<table class="table table-striped table-hover">';
			$result .= '<caption>Listado de registros</caption>';
			$result .= '<thead>';
			$result .= '<tr>';
			$result .= '<th>#</th>';
			$where = '';
			foreach( $arr[ $controller->table ][ 'fields' ] as $fields => $field ):
			
				if( $field['list'] ):
					$result .= '<th>' . $field['label'] . '</th>';
					$cols[] = $fields;
					$type[] = $field['type'];
				endif;
			
				if( !empty( $search ) ):
					switch ($field['type']):
						case 'text':
						case 'textarea':
						case 'radio':
						case 'select':
							$where .= $fields . ' LIKE \'%' . $search . '%\' or ';
							break;
						case 'number':
						case 'tel':
						case 'email':
							$where .= $fields . ' = \'' . $search . '\' or ';
							break;
					endswitch;
					
				endif;
			
			endforeach;
			
			if( !empty( $search ) ):
				$where = substr( $where, 0 , -3 );
				$where = '"where":"' . $where . '",';
			endif;

			$result .= '<th colspan="2" class="text-right"><a class="btn btn-sm btn-outline-success" role="button" onclick="mapperJs.action(\''.$module.'\',\''.$name.'\',\'form\',0);" href="javascript:;"><i data-feather="plus-circle"></i> Nuevo registro</a></th>';
			$result .= '</tr>';
			$result .= '</thead>';
			$result .= '<tbody>';
			if( $page > 0 ):
				
				$page = '"page":'.$page . ',';

			endif;

			if( $limit > 0 ):
				
				$limit = '"limit":'.$limit . ',';

			endif;

			$params = '{ ' . $page . ' ' . $limit . ' ' . $where . ' "order" : "' . $arr[ $controller->table ] ['table_config'] ['primary_key']  . ' desc" }';
			$list =  $controller->pagination( $params );
			if( haveRows( $list['list'] ) ):
				foreach( $list['list'] as $col ):
					$pk = $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ];
					$result .= '<tr>';
					$result .= '<td>' . $pk . '</td>';
					for( $i = 0; $i <= count( $cols ); $i++ ):
						switch( $type[ $i ] ):
							case 'number':
								$result .= '<td class="text-right">' . number_format( $col[ $cols[ $i ] ], 0 , '', '.' ) . '</td>';
								break;
							case 'checkbox':
								$result .= '<td class="text-center"><i class="' . ( $col[ $cols[ $i ] ] == 1 ? 'text-success' : 'text-muted' ) . '" data-feather="' . ( $col[ $cols[ $i ] ] == 1 ? 'check-circle' : 'minus-circle' ) . '"></i></td>';
								break;
							case 'date':
								$result .= '<td>' . date('d/m/Y', strtotime( $col[ $cols[ $i ] ] ) ) . '</td>';
								break;
							case 'timestamp':
								$result .= '<td>' . date('d/m/Y H:i', strtotime( $col[ $cols[ $i ] ] ) ) . '</td>';
								break;
							case 'image':
								$result .= '<td><img src="' . $col[ $prefix . '_small_url' ] . '" class="img-responsive"></td>';
								break;
							case 'select':
								$foreing_key = $arr[ $controller->table ] ['fields'] [ $cols[ $i ] ] [ 'fk_table' ];
								if( !empty( $foreing_key ) ):
									$fk_field = $arr[ $controller->table ] ['fields'] [ $cols[ $i ] ] [ 'label_options' ];
									$fk = new Controller( $foreing_key );
									$fk_params = '{"where":"'.$cols[ $i ].'='.$col[ $cols[ $i ] ].'"}';
									$fk_col = json_decode( $fk->list( $fk_params ), true );
									$result .= '<td>' . $fk_col[0][ $fk_field ] . '</td>';
								else:
									$result .= '<td>' . $col[ $cols[ $i ] ] . '</td>';
								endif;
								break;
							case 'text':
							default:
								$result .= '<td>' . $col[ $cols[ $i ] ] . '</td>';
						endswitch;
					endfor;
					$result .= '
					<td>
						<a href="javascript:;" title="Abrir registro" class="btn btn-outline-primary" onclick="mapperJs.modal(\''.$module.'\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i data-feather="file-text"></i></a>
						<a href="javascript:;" title="Editar registro" class="btn btn-outline-primary" onclick="mapperJs.action(\''.$module.'\',\''.$name.'\',\'form\','.$pk.');"><i data-feather="edit"></i></a>
						<a href="javascript:;" title="Eliminar registro" class="btn btn-outline-danger" onclick="mapperJs.action(\''.$module.'\',\''.$name.'\',\'delete\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i data-feather="delete"></i></a>
					</td>';
					$result .= '</tr>';

				endforeach;
				$result .= '</tbody>';
				$result .= '</table>';

				$navigation = $list['navigation'];

				$json = [ 'status' => 200, 'title' => ucfirst( $name ), 'result' => $result, 'navigation' => $navigation,"where" => $where  ];
			else:
				$result .= '</tbody>';
				$result .= '</table>';
				$json = [ 'status' => 404, 'message' => 'No se encontraron datos.', 'type' => 'warning', 'title' => ucfirst( $name ), 'result' => $result ];
			endif;
		else:
			$json = [ 'status' => 404, 'message' => 'Datos no encontrados.', 'type' => 'warning' ];
		endif;
		break;
	default:
		$json = [ 'status' => 404, 'message' => 'Ocurrio un error no se recibieron todos los datos.', 'type' => 'danger' ];
endswitch;

setApplicationJSON();
print json_encode( $json );