<?php

require_once __DIR__ . '/../../App/Model/DAO/FeedMapper.php';
require_once __DIR__ . '/../../App/Model/Entity/Feed.php';

use App\Model\DAO\FeedMapper;
use App\Model\Entity\Feed;

class FeedMapperTest extends PHPUnit_Framework_TestCase {

    private static $con = null;

    public static function setUpBeforeClass() {
        self::$con = new PDO('sqlite::memory:');
        self::$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$con->exec(file_get_contents(__DIR__ . '/../../db/init.sql'));
    }

    public function tearDown() {
        $stmt = self::$con->prepare('DELETE FROM feeds');
        $stmt->execute();
    }

    public function testInsertFeed() {
        $feedMapper = new FeedMapper(self::$con);
        $feed = new Feed(1, "Feed", "Description du feed", "Provider", "Type");

        $feedMapper->insert($feed);

        $stmt = self::$con->prepare('SELECT COUNT(*) FROM feeds');
        $stmt->execute();

        $this->assertEquals(1, $stmt->fetchColumn());
    }

    public function testUpdateFeed() {
        $feedMapper = new FeedMapper(self::$con);
        $feed = new Feed(0, "Feed", "Description du feed", "Provider", "Type");
        $newDescription = "Une autre description";

        $feedMapper->insert($feed);
        $feed->setDescription($newDescription);
        $feedMapper->update($feed);

        $stmt = self::$con->prepare('SELECT * FROM feeds');
        $array = $stmt->execute();

        $this->assertEquals(1, count($array));
        $this->assertEquals($newDescription, array_values($array)[0]->getDescription());
    }

    public function testDeleteFeed() {
        $feedMapper = new FeedMapper(self::$con);
        $feed1 = new Feed(0, "Feed 1", "Description du feed 1", "Provider", "Type");
        $feed2 = new Feed(0, "Feed 2", "Description du feed 2", "Provider", "Type");

        $feedMapper->insert($feed1);
        $feedMapper->insert($feed2);

        $feedMapper->delete($feed1);

        $stmt = self::$con->prepare('SELECT * FROM feeds');
        $array = $stmt->execute();

        $this->assertEquals(1, count($array));
    }
}
