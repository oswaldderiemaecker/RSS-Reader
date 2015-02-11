<?php

ini_set('date.timezone', 'Europe/Paris');

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->add("App", dirname(__DIR__));

$app = new Silex\Application();
$app['debug'] = true;

$app->mount("/", new App\Controller\IndexController());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    "twig.path" => dirname(__DIR__) . "/App/View",
    'twig.options' => array('cache' => dirname(__DIR__).'/cache', 'strict_variables' => true)
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->run();
