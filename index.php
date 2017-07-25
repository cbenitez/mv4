<?php
require_once __DIR__ . '/app/autoload.php';
ob_start("sanitize_output");
set_x_frame_deny();
set_xss_protection();
set_block_read_content_type();
set_cookie_secure();

$pages = include __DIR__ . '/app/config/pages.php';

$route = new Route();
if( array_key_exists( param('uri'), $pages ) ):
    foreach( $pages as $page => $method ):
        $route->add( '/' . $page, $method );
    endforeach;
else:
    new Error404;
endif;

$route->submit();
