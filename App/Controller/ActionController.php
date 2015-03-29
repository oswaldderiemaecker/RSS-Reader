<?php

require_once __DIR__ . '/../Model/PDO/Connection.php';
require_once __DIR__ . '/../Model/Entity/Feed.php';

use App\Model\Entity\Feed;
use App\Model\DAO\FeedMapper;
use App\Model\DAO\FeedFinder;

class ActionController {

    public function addFeed($link) {
        $con = Connection::getConnection();
        $feedMapper = new FeedMapper($con);

        $feed = new Feed("New feed", $link, "Description", new DateTime("Y-m-d H:i"), 0);
        $feedMapper->insert($feed);
    }

    public function deleteFeed($id) {
        $con = Connection::getConnection();
        $feedMapper = new FeedMapper($con);
        $feedFinder = new FeedFinder($con);

        $feed = $feedFinder->find($id);
        $feedMapper->delete($feed);
    }

    public function findAllFeeds() {
        $con = Connection::getConnection();
        $feedFinder = new FeedFinder($con);

        return $feedFinder->findAll();
    }

    public function findAllItems() {
        $con = Connection::getConnection();
        $itemFinder = new ItemFinder($con);

        return $itemFinder->findAll();
    }
}
