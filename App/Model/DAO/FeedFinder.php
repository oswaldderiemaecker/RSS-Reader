<?php

namespace App\Model\DAO;

require_once __DIR__ . '/../Entity/Feed.php';

use App\Model\Entity\Feed;
use DateTime;
use PDO;

class FeedFinder {

    private $con;

    public function __construct(PDO $con) {
        $this->con = $con;
    }

    public function findAll() {
        $stmt = $this->con->prepare('SELECT * FROM feeds ORDER BY date DESC');
        $arrayItem = array();

        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                $item = new Feed(
                    $row['title'],
                    $row['link'],
                    $row['description'],
                    new DateTime($row['date']),
                    $row['type']
                );

                $item->setId($row['id']);
                array_push($arrayItem, $item);
            }
        }

        return $arrayItem;
    }

    public function find($id) {
        $stmt = $this->con->prepare('SELECT * FROM feeds WHERE id = :id');
        $item = null;

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            $row = $stmt->fetch();

            $item = new Feed(
                $row['title'],
                $row['link'],
                $row['description'],
                new DateTime($row['date']),
                $row['type']
            );

            $item->setId($row['id']);
        }

        return $item;
    }
}
