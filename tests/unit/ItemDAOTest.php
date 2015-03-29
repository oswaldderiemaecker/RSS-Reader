<?php

require_once __DIR__ . '/../../App/Model/DAO/ItemMapper.php';
require_once __DIR__ . '/../../App/Model/Entity/Item.php';

use App\Model\DAO\ItemMapper;
use App\Model\Entity\Item;

class ItemMapperTest extends PHPUnit_Framework_TestCase {

    private static $con = null;

    public static function setUpBeforeClass() {

    }

}


$arrayFeed = array();
$stmt = $this->con->prepare('SELECT * from Feed');
if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        array_push($arrayFeed, new Feed($row['url'], $row['date'], $row['id']));
    }
}
return $arrayFeed;