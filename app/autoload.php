<?php
error_reporting(E_ALL ^E_NOTICE);
ini_set('display_errors', 1);
@session_start();
require_once __DIR__ . '/config/app.php';
/**
 * Carga de Clases
 */
function __autoload( $class ) {
    $class = strtolower( $class );
    $classFile = config()['route']['libs'] . $class . '.class.php';
    if( is_file( $classFile ) && !class_exists( $class ) ) require_once $classFile;
}
/**
 * Librerias
 */
Folder::Load    ( config()['route']['util'] );
/**
 * Modelos
 */
Folder::Load    ( config()['route']['models'] );
/**
 * Controladores
 */
Folder::Load    ( config()['route']['controllers'] );
/**
 * Vistas publicas
 */
Folder::Load    ( config()['route']['views'] . 'public/' );
/**
 * Vistas del dashboard
 */
Folder::Load    ( config()['route']['views'] . 'system/' );