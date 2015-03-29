<?php

require_once __DIR__ . '/../../App/Model/PDO/Connection.php';

use App\Model\PDO\Connection;

class ConnectionTest extends PHPUnit_Framework_TestCase {

    public function testConnection() {
        $this->assertNotNull(Connection::getConnection());
    }
}
