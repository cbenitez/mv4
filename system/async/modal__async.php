<?php
require_once '../../app/autoload.php';

$pk = numParam( 'pk' );
$module = strtolower( param( 'module' ) );

$controller = new Controller( $module );
$list_fields = $controller->table_fields();
$arr = json_decode( $list_fields, true );

$prefix = str_replace( '_id', '', $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] );

if( is_array( $arr[ $controller->table ][ 'fields' ] ) ):
	$table .= '<table class="table table-striped">';
	foreach( $arr[ $controller->table ][ 'fields' ] as $fields => $field ):
		$labels[]   = $field['label'];
		$cols[]     = $fields;
		$type[]     = $field['type'];
		$visible[]  = $field['visible'];
	endforeach;

	$table .= '<tbody>';
	$list = json_decode( $controller->list( '{"where":" ' . $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] . ' = ' . $pk . '"}' ), true );
	foreach( $list as $col ):
		$table .= '<tr><td><strong>#</strong></td><td>' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . '</td></tr>';
		for( $i = 0; $i < count( $cols ); $i++ ):
			if( $visible[ $i ] != 'false' ):
				
				$table .= '<tr>';
				
				if( empty( $labels[ $i ] ) ):
					$table .= '<td><strong>&nbsp;</strong></td>';
				else:
					$table .= '<td><strong>' . $labels[ $i ] . ':</strong></td>';
				endif;

				switch( $type[ $i ] ):
					case 'number':
						$table .= '<td>' . number_format( $col[ $cols[ $i ] ], 0 , '', '.' ) . '</td>';
					break;
					case 'checkbox':
						$table .= '<td><i class="' . ( $col[ $cols[ $i ] ] == 1 ? 'text-success' : 'text-muted' ) . '" data-feather="' . ( $col[ $cols[ $i ] ] == 1 ? 'check-circle' : 'minus-circle' ) . '"></i></td>';
					break;
					case 'date':
						$table .= '<td>' . date('d/m/Y', strtotime( $col[ $cols[ $i ] ] ) ) . '</td>';
						break;
					case 'timestamp':
						$table .= '<td>' . date('d/m/Y H:i', strtotime( $col[ $cols[ $i ] ] ) ) . '</td>';
						break;
					case 'image':
						$table .= '<td><img src="' . $col[ $prefix . '_small_url' ] . '" class="img-responsive"></td>';
						break;
					case 'file':
						break;
					case 'select':
						$foreing_key = $arr[ $controller->table ] ['fields'] [ $cols[ $i ] ] [ 'fk_table' ];
						if( !empty( $foreing_key ) ):
							$fk_field = $arr[ $controller->table ] ['fields'] [ $cols[ $i ] ] [ 'label_options' ];
							$fk = new Controller( $foreing_key );
							$fk_params = '{"where":"'.$cols[ $i ].'='.$col[ $cols[ $i ] ].'"}';
							$fk_col = json_decode( $fk->list( $fk_params ), true );
							$table .= '<td>' . $fk_col[0][ $fk_field ] . '</td>';
						else:
							$table .= '<td>' . $col[ $cols[ $i ] ] . '</td>';
						endif;
						break;
					case 'text':
					default:
						$table .= '<td>' . ucwords( $col[ $cols[ $i ] ] ) . '</td>';
				endswitch;

				$table .= '</tr>';

			endif;
		endfor;
	endforeach;
	$table .= '</tbody>';
	$table .= '</table>';
	print $table;
else:    
	print 'Datos no encontrados.';
endif;    