<?php

namespace App\Model\PDO;

use PDO;

class Connection extends PDO
{
    private static $instance = null;

    public function __construct() {
        try {
            parent::__construct('sqlite:' . __DIR__ . '/../../../db/db.sqlite3');
            parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $fp = fopen(__DIR__ . '/../../../db/log.txt', 'a');
            fprintf($fp, '[' . date('Y-m-d H:i:s') . ']' . "Connection failed : " . $e->getMessage() . "\n");
            fclose($fp);
        }
    }

    public static function getConnection()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Connection();
        }

        return self::$instance;
    }
}
