<?php 

require "vendor/autoload.php";

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$tattoo = new Tattoo\Tattoo(array('cache' => __DIR__ . '/cache/'));

echo $tattoo->render(__DIR__ . '/concept/test.tto', $_GET);