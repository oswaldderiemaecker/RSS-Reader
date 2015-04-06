<?php

require_once __DIR__ . '/../../App/Model/DAO/FeedMapper.php';
require_once __DIR__ . '/../../App/Model/DAO/FeedFinder.php';
require_once __DIR__ . '/../../App/Model/Entity/Feed.php';

use App\Model\DAO\FeedMapper;
use App\Model\DAO\FeedFinder;
use App\Model\Entity\Feed;
use App\Model\Entity\FeedType;

class FeedDAOTest extends PHPUnit_Framework_TestCase {

    private static $con = null;

    public static function setUpBeforeClass() {
        self::$con = new PDO('sqlite::memory:');
        self::$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$con->exec(file_get_contents(__DIR__ . '/../../db/init_test.sql'));
    }

    public static function tearDownAfterClass() {
        self::$con = null;
    }

    public function tearDown() {
        $stmt = self::$con->prepare('DELETE FROM feeds');
        $stmt->execute();
    }

    public function testInsertFeed() {
        $feedMapper = new FeedMapper(self::$con);
        $feed = new Feed("Feed", "Link", "Description du feed", new DateTime(), FeedType::RssFeed);

        $feedMapper->insert($feed);

        $stmt = self::$con->prepare('SELECT COUNT(*) FROM feeds');
        $stmt->execute();

        $this->assertEquals(1, $stmt->fetchColumn());
    }

    public function testFindAllFeeds() {
        $feedMapper = new FeedMapper(self::$con);
        $feed1 = new Feed("Feed 1", "Link", "Description du feed 1", new DateTime(), FeedType::RssFeed);
        $feed2 = new Feed("Feed 2", "Link", "Description du feed 2", new DateTime(), FeedType::AtomFeed);

        $feedMapper->insert($feed1);
        $feedMapper->insert($feed2);

        $feedFinder = new FeedFinder(self::$con);
        $array = $feedFinder->findAll();

        $this->assertEquals(2, count($array));
    }

    public function testFindFeed() {
        $feedMapper = new FeedMapper(self::$con);
        $feed1 = new Feed("Feed 1", "Link", "Description du feed 1", new DateTime(), FeedType::RssFeed);

        $feedMapper->insert($feed1);

        $feedFinder = new FeedFinder(self::$con);
        $feed2 = $feedFinder->find($feed1->getId());

        $this->assertEquals($feed1->getId(), $feed2->getId());
        $this->assertEquals($feed1->getTitle(), $feed2->getTitle());
        $this->assertEquals($feed1->getLink(), $feed2->getLink());
        $this->assertEquals($feed1->getDescription(), $feed2->getDescription());
        $this->assertEquals($feed1->getDate()->format('Y-m-d H:i'), $feed2->getDate()->format('Y-m-d H:i'));
        $this->assertEquals($feed1->getType(), $feed2->getType());
    }

    public function testUpdateFeed() {
        $feedMapper = new FeedMapper(self::$con);
        $feed = new Feed("Feed", "Link", "Description du feed", new DateTime(), FeedType::RssFeed);
        $newDescription = "Une autre description";

        $feedMapper->insert($feed);
        $feed->setDescription($newDescription);
        $feedMapper->update($feed);

        $feedFinder = new FeedFinder(self::$con);
        $array = $feedFinder->findAll();

        $this->assertEquals(1, count($array));
        $this->assertEquals($newDescription, array_values($array)[0]->getDescription());
    }

    public function testDeleteFeed() {
        $feedMapper = new FeedMapper(self::$con);
        $feed1 = new Feed("Feed 1", "Link", "Description du feed 1", new DateTime(), FeedType::RssFeed);
        $feed2 = new Feed("Feed 2", "Link", "Description du feed 2", new DateTime(), FeedType::RssFeed);

        $feedMapper->insert($feed1);
        $feedMapper->insert($feed2);

        $feedMapper->delete($feed1);

        $stmt = self::$con->prepare('SELECT * FROM feeds');
        $array = $stmt->execute();

        $this->assertEquals(1, count($array));
    }
}
