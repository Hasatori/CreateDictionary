<?php
define('INI_LOCATION', __DIR__ . '/config.ini');


$protocol = "https://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER["CONTEXT_PREFIX"] . '/';
define('BASE', $url."CreateDictionary/");