<?php

namespace App\Model\Entity;

use DateTime;

class Item {

    private $id;
    private $feed;
    private $title;
    private $link;
    private $description;
    private $date;

    public function __construct(Feed $feed, $title, $link, $description, DateTime $date) {
        $this->id = -1;
        $this->feed = $feed;
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
        $this->date = $date;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFeed() {
        return $this->feed;
    }

    public function setFeed(Feed $feed) {
        $this->feed = $feed;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate(DateTime $date) {
        $this->date = $date;
    }
}
