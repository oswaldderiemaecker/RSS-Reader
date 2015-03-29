<?php

require_once __DIR__ . '/../../App/Model/Entity/Feed.php';

use App\Model\Entity\Feed;
use App\Model\Entity\FeedType;

class FeedTest extends PHPUnit_Framework_TestCase {

    public function testNewFeed() {
        $title = "Google feed";
        $link = "http://www.google.fr";
        $description = "A small description";
        $date = new DateTime('2015-01-01 22:34');
        $type = FeedType::RssFeed;

        $feed = new Feed($title, $link, $description, $date, $type);

        $this->assertEquals($title, $feed->getTitle());
        $this->assertEquals($link, $feed->getLink());
        $this->assertEquals($description, $feed->getDescription());
        $this->assertEquals($date, $feed->getDate());
        $this->assertEquals($type, $feed->getType());
    }
}
