<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/WorkerCommand.php';

use Symfony\Component\Console\Application;

use App\Model\PDO\Connection;
use App\Worker\WorkerCommand;

$con = Connection::getConnection();
//$con->query(file_get_contents(__DIR__ . '/../../db/init.sql'));

$worker = new Application();
$worker->add(new WorkerCommand());
$worker->run();
