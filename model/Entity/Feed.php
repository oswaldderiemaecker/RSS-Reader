<?php

namespace App\Model\Entity;

use DateTime;

abstract class FeedType {
    const RssFeed = 0;
    const AtomFeed = 1;
}

class Feed {

    private $id;
    private $title;
    private $link;
    private $description;
    private $date;
    private $type;

    public function __construct($title, $link, $description, DateTime $date, $type) {
        $this->id = -1;
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
        $this->date = $date;
        $this->type = $type;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function setDate($date) {
        $this->date = $date;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
}