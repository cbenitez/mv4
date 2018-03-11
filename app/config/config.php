<?php
$project_name   = "Mapper V4";
$project_folder = "mv4";
return [
        "project_name"             => $project_name,
        "host"      => [
                      "site"       => ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['SERVER_NAME'] . DIRECTORY_SEPARATOR,
                      "app"        => ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['SERVER_NAME'] . DIRECTORY_SEPARATOR . $project_folder . DIRECTORY_SEPARATOR,
                      "assets"     => ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['SERVER_NAME'] . DIRECTORY_SEPARATOR . $project_folder . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR,
                      "sys_assets" => ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['SERVER_NAME'] . DIRECTORY_SEPARATOR . $project_folder . DIRECTORY_SEPARATOR . "system/assets" . DIRECTORY_SEPARATOR,
                      "name"       => $_SERVER['SERVER_NAME'],
                      "uri"        => $_SERVER['REQUEST_URI'],
                      "upload"     => ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['SERVER_NAME'] . DIRECTORY_SEPARATOR . $project_folder . DIRECTORY_SEPARATOR . "upload" . DIRECTORY_SEPARATOR
        ],
        "route"     => [
                      "root"        => realpath( dirname( __FILE__ ) ) . '/../..',
                      "app"         => realpath( dirname( __FILE__ ) ) . '/../../app/',
                      "tables"      => realpath( dirname( __FILE__ ) ) . '/../../app/config/tables/',
                      "libs"        => realpath( dirname( __FILE__ ) ) . '/../../app/core/libs/',
                      "util"        => realpath( dirname( __FILE__ ) ) . '/../../app/core/util/',
                      "log"         => realpath( dirname( __FILE__ ) ) . '/../../app/core/log/',
                      "models"      => realpath( dirname( __FILE__ ) ) . '/../../app/models/',
                      "controllers" => realpath( dirname( __FILE__ ) ) . '/../../app/controllers/',
                      "views"       => realpath( dirname( __FILE__ ) ) . '/../../app/views/',
                      "layout"      => realpath( dirname( __FILE__ ) ) . '/../../app/views/public/layout/',
                      "template"    => realpath( dirname( __FILE__ ) ) . '/../../app/cache/template/',
                      "assets"      => realpath( dirname( __FILE__ ) ) . '/../../assets/',
                      "includes"    => realpath( dirname( __FILE__ ) ) . '/../../includes/',
                      "sys_inc"     => realpath( dirname( __FILE__ ) ) . '/../../system/includes/',
                      "sys_layout"  => realpath( dirname( __FILE__ ) ) . '/../../app/views/system/layout/',
                      "upload"      => realpath( dirname( __FILE__ ) ) . '/../../upload/'
        ],
        "database"  => [
                      "type"        => "mysql",
                      "host"        => "localhost",
                      "name"        => "datos",
                      "user"        => "root",
                      "pass"        => "123456"
        ],
        "cache"     => [
                      "log"         =>  "On",
                      "template"    =>  "On",
                      "memcached"   =>  "Off",
        ],
        "authen"    => [
                      "authToken"   => "R6sdfh83GUSg34i8",
                      "userLogin"   => "_usl_" . strtolower( metaphone( $_SERVER['SERVER_NAME'] ) ),
                      "userAds"     => "_ads_" . strtolower( metaphone( $_SERVER['SERVER_NAME'] ) ),
                      "hash_pass_key"=> "catsFLYhigh2000miles"
        ],
        "menu_config" => json_decode( @file_get_contents( realpath( dirname( __FILE__ ) ) . '/../../app/config/tables/menu_config.json' ), true )
];