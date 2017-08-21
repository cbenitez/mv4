<?php
require_once '../../app/autoload.php';

$pk = numParam( 'pk' );
$module = strtolower( param( 'module' ) );

$controller = new Controller( $module );
$list_fields = $controller->table_fields();
$arr = json_decode( $list_fields, true );
if( is_array( $arr[ $controller->table ][ 'fields' ] ) ):
    $table .= '<table class="table table-striped">';
    foreach( $arr[ $controller->table ][ 'fields' ] as $fields => $field ):
        $labels[] = $field['label'];
        $cols[] = $fields;
    endforeach;
    $table .= '<tbody>';
    $list = json_decode( $controller->list( '{"where":" ' . $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] . ' = ' . $pk . '"}' ), true );
    foreach( $list as $col ):
        $table .= '<tr><td><strong>#</strong></td><td>' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . '</td></tr>';
        for( $i = 0; $i <= count( $cols ); $i++ ):
            $table .= '<tr>';
            $table .= '<td><strong>' . $labels[ $i ] . '</strong></td>';
            $suffix = end( explode( '_', $cols[ $i ] ) );
            switch( $suffix ):
                case 'status':
                    $table .= '<td ><i class="fa fa-' . ( $col[ $cols[ $i ] ] == 1 ? 'check-circle text-success' : 'minus-circle text-muted' ) . '"></i></td>';
                break;
                case 'timestamp':
                    $table .= '<td>' . date('d/m/Y H:i', strtotime( $col[ $cols[ $i ] ] ) ) . '</td>';
                break;
                default:
                    $table .= '<td>' . ucfirst( $col[ $cols[ $i ] ] ) . '</td>';
            endswitch;
            $table .= '</tr>';
        endfor;
    endforeach;
    $table .= '</tbody>';
    $table .= '</table>';
    print $table;
else:    
    print 'Datos no encontrados.';
endif;    