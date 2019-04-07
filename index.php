<?php
$mainDir = __DIR__;
$path_templates = 'public/views/templates';
//render all the things
require_once $path_templates . '\head.html';
require 'controller/top.php';
require_once $path_templates . '\body.php';
require_once $path_templates . '\footer.html';
