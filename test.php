<?php 

require "vendor/autoload.php";

$tattoo = new Tattoo\Tattoo(array('cache' => __DIR__ . '/cache/'));

echo $tattoo->render(__DIR__ . '/concept/test.tto', $_GET);