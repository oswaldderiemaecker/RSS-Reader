<?php

namespace App\Model\DAO;

require_once __DIR__ . '/FeedFinder.php';

use App\Model\Entity\Item;
use PDO;
use DateTime;

class ItemFinder {

    private $con;

    public function __construct(PDO $con) {
        $this->con = $con;
    }

    public function findAll() {
        $stmt = $this->con->prepare('SELECT * FROM items ORDER BY date DESC');
        $arrayItem = array();
        $feedFinder = new FeedFinder($this->con);

        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                $feed = $feedFinder->find($row['id_feed']);

                $item = new Item(
                    $feed,
                    $row['title'],
                    $row['link'],
                    $row['description'],
                    new DateTime($row['date'])
                );

                $item->setId($row['id']);
                array_push($arrayItem, $item);
            }
        }

        return $arrayItem;
    }

    public function find($id)
    {
        $stmt = $this->con->prepare('SELECT * FROM items WHERE id = :id');
        $feedFinder = new FeedFinder($this->con);
        $item = null;

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            $row = $stmt->fetch();
            $feed = $feedFinder->find($row['id_feed']);

            $item = new Item(
                $feed,
                $row['title'],
                $row['link'],
                $row['description'],
                new DateTime($row['date'])
            );

            $item->setId($row['id']);
        }

        return $item;
    }
}
