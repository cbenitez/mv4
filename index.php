<?php
require_once __DIR__ . '/app/autoload.php';
ob_start("sanitize_output");
set_x_frame_deny();
set_xss_protection();
set_block_read_content_type();
set_cookie_secure();

$route = new Route();

$page = param('uri');
$page = rtrim($page, '/');
$page = filter_var($page, FILTER_SANITIZE_URL);
$page = explode( '/', $page );
$page[0] = empty( $page[0] ) ? 'index' : $page[0];
$route->add( '/' . $page[0], ucfirst( $page[0] ) );

$route->submit();
