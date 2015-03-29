<?php

require_once __DIR__ . '/../../App/Model/DAO/FeedMapper.php';
require_once __DIR__ . '/../../App/Model/DAO/ItemMapper.php';
require_once __DIR__ . '/../../App/Model/DAO/ItemFinder.php';
require_once __DIR__ . '/../../App/Model/Entity/Item.php';
require_once __DIR__ . '/../../App/Model/Entity/Feed.php';

use App\Model\DAO\FeedMapper;
use App\Model\DAO\ItemMapper;
use App\Model\DAO\ItemFinder;
use App\Model\Entity\Item;
use App\Model\Entity\Feed;
use App\Model\Entity\FeedType;

class ItemDAOTest extends PHPUnit_Framework_TestCase {

    private static $con = null;

    private static $feed = null;

    public static function setUpBeforeClass() {
        self::$con = new PDO('sqlite::memory:');
        self::$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$con->exec(file_get_contents(__DIR__ . '/../../db/init.sql'));

        self::$feed = new Feed("Feed", "Link", "Description du feed", new DateTime(), FeedType::RssFeed);

        $feedMapper = new FeedMapper(self::$con);
        $feedMapper->insert(self::$feed);
    }

    public static function tearDownAfterClass() {
        $stmt = self::$con->prepare('DELETE FROM feeds');
        $stmt->execute();
        self::$con = null;
    }

    public function tearDown() {
        $stmt = self::$con->prepare('DELETE FROM items');
        $stmt->execute();
    }

    public function testInsertItem() {
        $itemMapper = new ItemMapper(self::$con);
        $item = new Item(self::$feed, "Item", "Lien item", "Source item", date('Y-m-d H:i:s'), "Contenu lien");

        $itemMapper->insert($item);

        $stmt = self::$con->prepare('SELECT COUNT(*) FROM items');
        $stmt->execute();

        $this->assertEquals(1, $stmt->fetchColumn());
    }

    public function testFindAllItems() {
        $itemMapper = new ItemMapper(self::$con);
        $item1 = new Item(self::$feed, "Item 1", "Lien item 1", "Source item 1", date('Y-m-d H:i:s'), "Contenu lien 1");
        $item2 = new Item(self::$feed, "Item 2", "Lien item 2", "Source item 2", date('Y-m-d H:i:s'), "Contenu lien 2");

        $itemMapper->insert($item1);
        $itemMapper->insert($item2);

        $itemFinder = new ItemFinder(self::$con);
        $array = $itemFinder->findAll();

        $this->assertEquals(2, count($array));
    }

    public function testFindFeed() {
        $itemMapper = new ItemMapper(self::$con);
        $item1 = new Item(self::$feed, "Item", "Lien item", "Source item", date('Y-m-d H:i:s'), "Contenu lien");

        $itemMapper->insert($item1);

        $itemFinder = new ItemFinder(self::$con);
        $item2 = $itemFinder->find($item1->getId());

        $this->assertEquals($item1->getFeed()->getId(), $item2->getFeed()->getId());
        $this->assertEquals($item1->getTitle(), $item2->getTitle());
        $this->assertEquals($item1->getLink(), $item2->getLink());
        $this->assertEquals($item1->getDescription(), $item2->getDescription());
        $this->assertEquals($item1->getDate(), $item2->getDate());
    }

    public function testUpdateItem() {
        $itemMapper = new ItemMapper(self::$con);
        $item = new Item(self::$feed, "Item", "Lien item", "Source item", date('Y-m-d H:i:s'), "Contenu lien");
        $newLink = "Un autre lien";

        $itemMapper->insert($item);
        $item->setLink($newLink);
        $itemMapper->update($item);

        $itemFinder = new ItemFinder(self::$con);
        $array = $itemFinder->findAll();

        $this->assertEquals(1, count($array));
        $this->assertEquals($newLink, array_values($array)[0]->getLink());
    }

    public function testDeleteItem() {
        $itemMapper = new ItemMapper(self::$con);
        $item1 = new Item(self::$feed, "Item 1", "Lien item 1", "Source item 1", date('Y-m-d H:i:s'), "Contenu lien 1");
        $item2 = new Item(self::$feed, "Item 2", "Lien item 2", "Source item 2", date('Y-m-d H:i:s'), "Contenu lien 2");

        $itemMapper->insert($item1);
        $itemMapper->insert($item2);

        $itemMapper->delete($item1);

        $stmt = self::$con->prepare('SELECT * FROM items');
        $array = $stmt->execute();

        $this->assertEquals(1, count($array));
    }
}
