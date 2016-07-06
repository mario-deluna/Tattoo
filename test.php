<?php 

require "vendor/autoload.php";

// $whoops = new \Whoops\Run;
// $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
// $whoops->register();

$tattoo = new Tattoo\Tattoo(array('cache' => __DIR__ . '/cache/'));

header('Content-Type: text/plain');
//print_r($tattoo->parse(file_get_contents(__DIR__ . '/concept/test.tto'))); die;

echo $tattoo->render(__DIR__ . '/concept/test.tto', $_GET);

// try {
// 	echo $tattoo->render(__DIR__ . '/concept/test.tto', $_GET);
// }
// catch(Exception $exception)
// {
// 	echo 'Tattoo error: ' . $exception->getMessage() . "\n";
// }
