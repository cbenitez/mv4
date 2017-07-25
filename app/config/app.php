<?php
function config(){
    define('CONFIG', include __DIR__ . DIRECTORY_SEPARATOR . 'config.php');
    return CONFIG;
}