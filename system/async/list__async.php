<?php
require_once '../../app/autoload.php';

$task   = param( 'task' );
$module = strtolower( param( 'module' ) );
$page   =  numParam( 'page' );
$limit  =  numParam( 'limit' );
$search =  param( 'search' );

switch( $task ):
    case 'list':
        /*
         * Miga de pan
         */
        $result = '<ol class="breadcrumb">';
        $result .= '<li><a href="' . config()['host']['app'] . 'dashboard">Dashboard</a></li>';
        $result .= '<li class="active">' . ucfirst( $module ) . '</li>';
        $result .= '</ol>';

        /*
         * Titulo del modulo
         */
        $result .= '<h1 class="page-header">' . ucfirst( $module ) . '</h1>';

        /*
         * Formulario de busqueda
         */
        $result .= '<form action="" method="post" enctype="text/plain" onsubmit="mapperJs.list(\''.$module.'\');return false;">';
        $result .= ' <div class="form-group">';
        $result .= '     <div class="input-group">';
        $result .= '         <input type="text" class="form-control" name="search" id="search" placeholder="Escriba aqui para filtrar...">';
        $result .= '         <div class="input-group-btn">';
        $result .= '             <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>';
        $result .= '         </div>';
        $result .= '     </div>';
        $result .= ' </div>';
        $result .= '</form>';

        /*
         * Boton para nuevo registro
         */
        $result .= '<div class="row">';
        $result .= ' <div class="col-md-2 col-md-offset-10 text-right">';
        $result .= '     <button class="btn btn-success" type="button" onclick="mapperJs.action(\''.$module.'\',\'form\',0);"><i class="fa fa-plus-circle"></i> Nuevo registro</button>';
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
            $where = '';
            
            foreach( $arr[ $controller->table ][ 'fields' ] as $fields => $field ):
            
                if( $field['list'] ):
                    $result .= '<th>' . $field['label'] . '</th>';
                    $cols[] = $fields;
                endif;
            
                if( !empty( $search ) ):
                    $where .= $fields . '"%' . $search . '%" OR ';
                endif;
            
            endforeach;
            
            if( !empty( $search ) ):
                $where = substr( $where, 0 , -3 );
                $where = '"where":' . $where . ',';
            endif;

            $result .= '<th colspan="2">&nbsp;</th>';
            $result .= '</tr>';
            $result .= '</thead>';
            $result .= '<tbody>';

            if( $page > 0 ):
                
                $page = '"page":'.$page . ',';

            endif;

            if( $limit > 0 ):
                
                $limit = '"limit":'.$limit . ',';

            endif;

            $params = '{ ' . $page . ' ' . $limit . ' ' . $where . ' "order" : "' . $arr[ $controller->table] ['table_config'] ['primary_key']  . ' desc" }';
            $list =  $controller->pagination( $params );
            foreach( $list['list'] as $col ):
                $pk = $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ];
                $result .= '<tr>';
                $result .= '<td>' . $pk . '</td>';
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
                    <a href="javascript:;" title="Editar registro" class="btn btn-primary" onclick="mapperJs.action(\''.$module.'\',\'form\','.$pk.');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a href="javascript:;" title="Eliminar registro" class="btn btn-danger" onclick="action(\'delete\',' . $col[ $arr[ $controller->table ][ 'table_config' ][ 'primary_key' ] ] . ');"><i class="fa fa-times" aria-hidden="true"></i></a>
                </td>';
                $result .= '</tr>';

            endforeach;
            $result .= '</tbody>';
            $result .= '</table>';

            $navigation = $list['navigation'];

            $json = [ 'status' => 200, 'result' => $result, 'navigation' => $navigation ];
        else:
            $json = [ 'status' => 404, 'message' => 'Datos no encontrados.', 'type' => 'warning' ];
        endif;
        break;
    default:
        $json = [ 'status' => 404, 'message' => 'Ocurrio un error no se recibieron todos los datos.', 'type' => 'danger' ];
endswitch;

setApplicationJSON();
print json_encode( $json );