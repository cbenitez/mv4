<?php
require_once '../../../app/autoload.php';

$task = param( 'task' );
$module = strtolower( param( 'module' ) );

switch( $task ):
    case 'list':
        $table = '<h2>' . param( 'module' ) . '</h2>';
        $controller = new Controller( $module );
        $list_fields = $controller->table_fields();
        $arr = json_decode( $list_fields, true );
        if( is_array( $arr[ $controller->table ][ 'fields' ] ) ):
            $table .= '<table class="table table-striped">';
            $table .= '<thead>';
            $table .= '<tr>';
            foreach( $arr[ $controller->table ][ 'fields' ] as $fields => $field ):
                $table .= '<th>' . $field['label'] . '</th>';
                $cols[] = $fields;
            endforeach;
            $table .= '</tr>';
            $table .= '</thead>';
            $table .= '<tbody>';
            $list = json_decode( $controller->list(), true );
            foreach( $list as $col ):
                $table .= '<tr>';
                for( $i = 0; $i <= count( $cols ); $i++ ):
                    $table .= '<td>' . $col[ $cols[ $i ] ] . '</td>';
                endfor;
                $table .= '</tr>';
            endforeach;
            $table .= '</tbody>';
            $table .= '</table>';
            $json = [ 'status' => 200, 'list' => $table ];
        else:
            $json = [ 'status' => 404, 'message' => 'Datos no encontrados.', 'type' => 'warning' ];
        endif;
    break;
    default:
endswitch;

setApplicationJSON();
print json_encode( $json );