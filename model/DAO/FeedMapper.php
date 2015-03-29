<?php

namespace App\Model\DAO;

use App\Model\Entity\Feed;
use PDO;

class FeedMapper {

    private $con;

    public function __construct(PDO $con) {
        $this->con = $con;
    }

    public function insert(Feed $feed) {
        $stmt = $this->con->prepare(<<<SQL
INSERT INTO feeds(title, link, description, date, type)
VALUES (:title, :link, :description, :date, :type)
SQL
        );

        $stmt->bindValue(':title', $feed->getTitle());
        $stmt->bindValue(':link', $feed->getLink());
        $stmt->bindValue(':description', $feed->getDescription());
        $stmt->bindValue(':date', $feed->getDate()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':type', $feed->getType());

        $res = $stmt->execute();
        $feed->setId($this->con->lastInsertId());
        return $res;
    }

    public function update(Feed $feed) {
        $stmt = $this->con->prepare(<<<SQL
UPDATE feeds
SET title = :title, description = :description, link = :link, date = :date, type = :type
WHERE id = :id
SQL
        );

        $stmt->bindValue(':id', $feed->getId());
        $stmt->bindValue(':title', $feed->getTitle());
        $stmt->bindValue(':description', $feed->getDescription());
        $stmt->bindValue(':link', $feed->getLink());
        $stmt->bindValue(':date', $feed->getDate()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':type', $feed->getType());

        return $stmt->execute();
    }

    public function delete(Feed $feed) {
        $stmt = $this->con->prepare('DELETE FROM feeds WHERE id = :id');

        $stmt->bindValue(':id', $feed->getId());

        return $stmt->execute();
    }
}
