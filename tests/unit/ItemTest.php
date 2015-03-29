<?php

require_once __DIR__ . '/../../App/Model/Entity/Item.php';

use App\Model\Entity\Feed;
use App\Model\Entity\FeedType;
use App\Model\Entity\Item;

class ItemTest extends PHPUnit_Framework_TestCase {

    public function testNewItem() {
        $title = "Google item";
        $link = "http://www.google.fr";
        $description = "Description";
        $date = new DateTime('2015-01-01 22:34');

        $feed = new Feed("Feed 1", "Description du feed 1", "http://www.google.fr", new DateTime('2015-01-01'), FeedType::AtomFeed);
        $item = new Item($feed, $title, $link, $description, $date);

        $this->assertEquals($feed, $item->getFeed());
        $this->assertEquals($title, $item->getTitle());
        $this->assertEquals($link, $item->getLink());
        $this->assertEquals($description, $item->getDescription());
        $this->assertEquals($date, $item->getDate());
    }
}
