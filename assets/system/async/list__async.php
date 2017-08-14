<?php
require_once '../../../app/autoload.php';

$task = param( 'task' );
$module = strtolower( param( 'module' ) );

switch( $task ):
    case 'list':
        $table = '<h2>' . ucfirst( $module ) . '</h2>';
        $controller = new Controller( $module );
        $list_fields = $controller->table_fields();
        $arr = json_decode( $list_fields, true );
        if( is_array( $arr[ $controller->table ][ 'fields' ] ) ):
            $table .= '<table class="table table-striped">';
            $table .= '<thead>';
            $table .= '<tr>';
            $table .= '<th>#</th>';
            foreach( $arr[ $controller->table ][ 'fields' ] as $fields => $field ):
                if( $field['list'] ):
                    $table .= '<th>' . $field['label'] . '</th>';
                    $cols[] = $fields;
                endif;
            endforeach;
            $table .= '<th colspan="2">&nbsp;</th>';
            $table .= '</tr>';
            $table .= '</thead>';
            $table .= '<tbody>';
            $list = json_decode( $controller->list(), true );
            foreach( $list as $col ):
                $table .= '<tr>';
                $table .= '<td>' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . '</td>';
                for( $i = 0; $i <= count( $cols ); $i++ ):
                    $suffix = end( explode( '_', $cols[ $i ] ) );
                    switch( $suffix ):
                        case 'status':
                            $table .= '<td align="center"><i class="fa fa-' . ( $col[ $cols[ $i ] ] == 1 ? 'check-circle text-success' : 'minus-circle text-muted' ) . '"></i></td>';
                        break;
                        case 'timestamp':
                            $table .= '<td>' . date('d/m/Y H:i', strtotime( $col[ $cols[ $i ] ] ) ) . '</td>';
                        break;
                        default:
                            $table .= '<td>' . $col[ $cols[ $i ] ] . '</td>';
                    endswitch;
                endfor;
                $table .= '<td>
                    <a href="javascript:;" title="Abrir registro" class="btn btn-primary" onclick="mapperJs.modal(\''.$module.'\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i class="fa fa-folder-open" aria-hidden="true"></i></a>
                    <a href="javascript:;" title="Editar registro" class="btn btn-primary" onclick="action(\'edit\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a href="javascript:;" title="Eliminar registro" class="btn btn-danger" onclick="action(\'delete\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i class="fa fa-times" aria-hidden="true"></i></a>
                </td>';
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