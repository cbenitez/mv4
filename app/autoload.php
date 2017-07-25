<?php
error_reporting(E_ALL ^E_NOTICE);
ini_set('display_errors', 1);
@session_start();
require_once __DIR__ . '/config/app.php';
/**
 * Carga de Clases
 */
require_once config()['route']['classes']   .   'route.class.php';
require_once config()['route']['classes']   .   'minify.class.php';
require_once config()['route']['classes']   .   'logger.class.php';
require_once config()['route']['classes']   .   'folder.class.php';
require_once config()['route']['classes']   .   'encryption.class.php';
require_once config()['route']['classes']   .   'tova.class.php';
/**
 * Librerias
 */
Folder::Load    ( config()['route']['lib'] );
/**
 * Modelos
 */
Folder::Load    ( config()['route']['model'] );
/**
 * Controladores
 */
Folder::Load    ( config()['route']['controller'] );
/**
 * Vistas publicas
 */
Folder::Load    ( config()['route']['view'] . 'public/' );
/**
 * Vistas del dashboard
 */
Folder::Load    ( config()['route']['view'] . 'system/' );