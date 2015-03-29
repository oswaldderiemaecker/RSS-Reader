<?php

require_once __DIR__ . '/Model/PDO/Connection.php';
require_once __DIR__ . '/Model/Worker/WorkerCommand.php';

use App\Model\PDO\Connection;
use App\Model\Worker\WorkerCommand;

use Symfony\Component\Console\Application;

ini_set('date.timezone', 'Europe/Paris');

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->add("App", dirname(__DIR__));

$con = Connection::getConnection();
$con->query(file_get_contents(__DIR__ . '/../db/init.sql'));

$worker = new Application();
$worker->add(new WorkerCommand());
$worker->run();

$app = new Silex\Application();
$app['debug'] = true;

$app->mount("/", new App\Controller\IndexController());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    "twig.path" => dirname(__DIR__) . "/App/View",
    'twig.options' => array('cache' => dirname(__DIR__).'/cache', 'strict_variables' => true)
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->run();
