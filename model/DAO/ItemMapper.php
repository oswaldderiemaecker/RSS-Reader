<?php

namespace App\Model\DAO;

use App\Model\Entity\Item;
use PDO;

class ItemMapper {

    private $con;

    public function __construct(PDO $con) {
        $this->con = $con;
    }

    public function insert(Item $item) {
        $stmt = $this->con->prepare(<<<SQL
INSERT INTO items(id_feed, title, link, description, date)
VALUES (:id_feed, :title, :link, :description, :date)
SQL
        );

        $stmt->bindValue(':id_feed', $item->getFeed()->getId());
        $stmt->bindValue(':title', $item->getTitle());
        $stmt->bindValue(':link', $item->getLink());
        $stmt->bindValue(':description', $item->getDescription());
        $stmt->bindValue(':date', $item->getDate());

        $res = $stmt->execute();
        $item->setId($this->con->lastInsertId());
        return $res;
    }

    public function update(Item $item) {
        $stmt = $this->con->prepare(<<<SQL
UPDATE items
SET id_feed = :id_feed, title = :title, link = :link, description = :description, date = :date
WHERE id = :id
SQL
        );

        $stmt->bindValue(':id', $item->getId());
        $stmt->bindValue(':id_feed', $item->getFeed()->getId());
        $stmt->bindValue(':title', $item->getTitle());
        $stmt->bindValue(':link', $item->getLink());
        $stmt->bindValue(':description', $item->getDescription());
        $stmt->bindValue(':date', $item->getDate());

        return $stmt->execute();
    }

    public function delete(Item $item) {
        $stmt = $this->con->prepare('DELETE FROM items WHERE id = :id');

        $stmt->bindValue(':id', $item->getId());

        return $stmt->execute();
    }
}
