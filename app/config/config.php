<?php
return [
        "project_name"             => "Mapper V4",
        "host"      => [
                      "app"        => "mv4",
                      "site"       => "http://" . $_SERVER['SERVER_NAME'] . ( $_SERVER['SERVER_PORT'] != "80" ? ":" . $_SERVER['SERVER_PORT'] : "" ) . DIRECTORY_SEPARATOR . "mv4" . DIRECTORY_SEPARATOR,
                      "assets"     => "http://" . $_SERVER['SERVER_NAME'] . ( $_SERVER['SERVER_PORT'] != "80" ? ":" . $_SERVER['SERVER_PORT'] : "" ) . DIRECTORY_SEPARATOR . "mv4" . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR,
                      "sys_assets" => "http://" . $_SERVER['SERVER_NAME'] . ( $_SERVER['SERVER_PORT'] != "80" ? ":" . $_SERVER['SERVER_PORT'] : "" ) . DIRECTORY_SEPARATOR . "mv4" . DIRECTORY_SEPARATOR . "dashboard/assets" . DIRECTORY_SEPARATOR,
                      "name"       => $_SERVER['SERVER_NAME'] . ( $_SERVER['SERVER_PORT'] != "80" ? ":" . $_SERVER['SERVER_PORT'] : "" ),
                      "uri"        => $_SERVER['REQUEST_URI']
        ],
        "route"     => [
                      "root"        => realpath(dirname( __FILE__ ) ) . '/../..',
                      "app"         => realpath(dirname( __FILE__ ) ) . '/../../app/',
                      "classes"     => realpath(dirname( __FILE__ ) ) . '/../../app/core/classes/',
                      "lib"         => realpath(dirname( __FILE__ ) ) . '/../../app/core/lib/',
                      "log"         => realpath(dirname( __FILE__ ) ) . '/../../app/core/log/',
                      "model"       => realpath(dirname( __FILE__ ) ) . '/../../app/model/',
                      "controller"  => realpath(dirname( __FILE__ ) ) . '/../../app/controller/',
                      "view"        => realpath(dirname( __FILE__ ) ) . '/../../app/view/',
                      "layout"      => realpath(dirname( __FILE__ ) ) . '/../../app/view/public/layout/',
                      "template"    => realpath(dirname( __FILE__ ) ) . '/../../app/cache/template/',
                      "assets"      => realpath(dirname( __FILE__ ) ) . '/../../assets/',
                      "includes"    => realpath(dirname( __FILE__ ) ) . '/../../assets/includes/',
                      "sys_inc"     => realpath(dirname( __FILE__ ) ) . '/../../dashboard/includes/',
                      "sys_layout"  => realpath(dirname( __FILE__ ) ) . '/../../app/view/system/layout/',
                      "sys_assets"  => realpath(dirname( __FILE__ ) ) . '/../../dashboard/system/assets/'
        ],
        "database"  => [
                      "host"        => "localhost",
                      "name"        => "testdb",
                      "user"        => "root",
                      "pass"        => "password"
        ],
        "cache"     => [
                      "log"         =>  "On",
                      "template"    =>  "On",
                      "memcached"   =>  "Off",
        ],
        "authen"    => [
                      "authToken"   => "R6sdfh83GUSg34i8",
                      "userLogin"   => "_usl_" . strtolower(metaphone($_SERVER['SERVER_NAME'])),
                      "userAds"     => "_ads_" . strtolower(metaphone($_SERVER['SERVER_NAME'])),
        ]
];
          