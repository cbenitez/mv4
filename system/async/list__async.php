<?php
require_once '../../app/autoload.php';

$task = param( 'task' );
$module = strtolower( param( 'module' ) );

switch( $task ):
    case 'list':
        /*
         * Miga de pan
         */
        $result = '<ol class="breadcrumb">';
        $result .= '<li><a href="./">Dashboard</a></li>';
        $result .= '<li class="active">' . ucfirst( $module ) . '</li>';
        $result .= '</ol>';

        /*
         * Titulo del modulo
         */
        $result .= '<h2>' . ucfirst( $module ) . '</h2>';

        /*
         * Formulario de busqueda
         */
        $result .= '<form action="" method="post" enctype="text/plain">';
        $result .= ' <div class="form-group">';
        $result .= '     <div class="input-group">';
        $result .= '         <input type="text" class="form-control" id="search" placeholder="Escriba aqui para filtrar...">';
        $result .= '         <div class="input-group-btn">';
        $result .= '             <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>';
        $result .= '         </div>';
        $result .= '     </div>';
        $result .= ' </div>';
        $result .= '</form>';

        /*
         * Boton para nuevo registro
         */
        $result .= '<div class="row">';
        $result .= ' <div class="col-md-2 col-md-offset-10 text-right">';
        $result .= '     <button class="btn btn-success" type="button"><i class="fa fa-plus-circle"></i> Nuevo registro</button>';
        $result .= ' </div>';
        $result .= '</div>';
        
        /*
         * Lista de registros dinamica
         */
        $controller = new Controller( $module );
        $list_fields = $controller->table_fields();
        $arr = json_decode( $list_fields, true );
        if( is_array( $arr[ $controller->table ][ 'fields' ] ) ):
            $result .= '<table class="table table-striped table-hover">';
            $result .= '<caption>Listado de registros</caption>';
            $result .= '<thead>';
            $result .= '<tr>';
            $result .= '<th>#</th>';
            foreach( $arr[ $controller->table ][ 'fields' ] as $fields => $field ):
                if( $field['list'] ):
                    $result .= '<th>' . $field['label'] . '</th>';
                    $cols[] = $fields;
                endif;
            endforeach;
            $result .= '<th colspan="2">&nbsp;</th>';
            $result .= '</tr>';
            $result .= '</thead>';
            $result .= '<tbody>';
            $list = json_decode( $controller->list(), true );
            foreach( $list as $col ):
                $result .= '<tr>';
                $result .= '<td>' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . '</td>';
                for( $i = 0; $i <= count( $cols ); $i++ ):
                    $suffix = end( explode( '_', $cols[ $i ] ) );
                    switch( $suffix ):
                        case 'status':
                            $result .= '<td align="center"><i class="fa fa-' . ( $col[ $cols[ $i ] ] == 1 ? 'check-circle text-success' : 'minus-circle text-muted' ) . '"></i></td>';
                        break;
                        case 'timestamp':
                            $result .= '<td>' . date('d/m/Y H:i', strtotime( $col[ $cols[ $i ] ] ) ) . '</td>';
                        break;
                        default:
                            $result .= '<td>' . $col[ $cols[ $i ] ] . '</td>';
                    endswitch;
                endfor;
                $result .= '<td>
                    <a href="javascript:;" title="Abrir registro" class="btn btn-primary" onclick="mapperJs.modal(\''.$module.'\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i class="fa fa-folder-open" aria-hidden="true"></i></a>
                    <a href="javascript:;" title="Editar registro" class="btn btn-primary" onclick="action(\'edit\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a href="javascript:;" title="Eliminar registro" class="btn btn-danger" onclick="action(\'delete\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i class="fa fa-times" aria-hidden="true"></i></a>
                </td>';
                $result .= '</tr>';

            endforeach;
            $result .= '</tbody>';
            $result .= '</table>';
            $json = [ 'status' => 200, 'result' => $result ];
        else:
            $json = [ 'status' => 404, 'message' => 'Datos no encontrados.', 'type' => 'warning' ];
        endif;
        break;
    default:
        $json = [ 'status' => 404, 'message' => 'Ocurrio un error no se recibieron todos los datos.', 'type' => 'danger' ];
endswitch;

setApplicationJSON();
print json_encode( $json );