<?php
return [
	"project_name"             => ( $project_name   = "Mapper V4" ),
	"project_folder"           => ( $project_folder = "mv4" ),
	"host"      => [
		      "site"       => ( $host = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['SERVER_NAME'] . DIRECTORY_SEPARATOR ),
		      "app"        => $host . $project_folder . DIRECTORY_SEPARATOR,
		      "assets"     => $host . $project_folder . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR,
		      "sys_assets" => $host . $project_folder . DIRECTORY_SEPARATOR . "system/assets" . DIRECTORY_SEPARATOR,
		      "name"       => ( $servername = $_SERVER['SERVER_NAME'] ),
		      "uri"        => $_SERVER['REQUEST_URI'],
		      "upload"     => $host . $project_folder . DIRECTORY_SEPARATOR . "upload" . DIRECTORY_SEPARATOR
	],
	"route"     => [
		      "root"        => ($realpath = realpath( dirname( __FILE__ ) ) . '/../..' ),
		      "app"         => $realpath . '/app/',
		      "tables"      => $realpath . '/app/config/tables/',
		      "libs"        => $realpath . '/app/core/libs/',
		      "util"        => $realpath . '/app/core/util/',
		      "log"         => $realpath . '/app/core/log/',
		      "models"      => $realpath . '/app/models/',
		      "controllers" => $realpath . '/app/controllers/',
		      "views"       => $realpath . '/app/views/',
		      "layout"      => $realpath . '/app/views/public/layout/',
		      "template"    => $realpath . '/app/cache/template/',
		      "assets"      => $realpath . '/assets/',
		      "includes"    => $realpath . '/includes/',
		      "sys_inc"     => $realpath . '/system/includes/',
		      "sys_layout"  => $realpath . '/app/views/system/layout/',
		      "upload"      => $realpath . '/upload/'
	],
	"database"  => [
		      "type"        => "mysql",
		      "host"        => "localhost",
		      "name"        => "datos",
		      "user"        => "root",
		      "pass"        => "123456"
	],
	"cache"     => [
		      "log"         =>  true,
		      "template"    =>  false,
		      "memcached"   =>  false,
	],
	"authen"    => [
		      "authToken"   => "R6sdfh83GUSg34i8",
		      "userLogin"   => "_usl_" . strtolower( metaphone( $servername ) ),
		      "adminLogin"  => "_adl_" . strtolower( metaphone( $servername ) ),
		      "hash_pass_key"=> "catsFLYhigh2000miles"
	],
	"cookie"	=> [
				"name"		=> "_mppr_",
				"expire"	=> time() + (3600 * 12), //expira en 12 horas
				"path"		=> "/",
				"domain"	=> strtolower( $servername ),
				"secure"	=> false,
				"httponly"	=> false
	],
	"menu_config" => json_decode( @file_get_contents( $realpath . '/app/config/tables/menu_config.json' ), true )
];