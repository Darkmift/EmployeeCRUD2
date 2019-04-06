<?php
$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= $_SERVER['REQUEST_URI'];

$path_templates = 'public/views/templates';
//render all the things
require_once $path_templates . '\head.html';
require_once $path_templates . '\body.php';
require_once $path_templates . '\footer.html';
