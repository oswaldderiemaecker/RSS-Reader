<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/ActionController.php';

use App\Controller\ActionController;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

ini_set('date.timezone', 'Europe/Paris');

$app = new Silex\Application();
$app['debug'] = true;

$app->mount("/", new ActionController());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => dirname(__DIR__) . '/View',
    'twig.options' => array('cache' => dirname(__DIR__) . '/cache', 'strict_variables' => true)
));

$app->register(new UrlGeneratorServiceProvider());
$app->run();
