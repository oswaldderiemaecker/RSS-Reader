<?php

namespace App\Model\Worker;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../PDO/Connection.php';
require_once __DIR__ . '/../DAO/FeedMapper.php';
require_once __DIR__ . '/../DAO/FeedFinder.php';
require_once __DIR__ . '/../DAO/ItemMapper.php';
require_once __DIR__ . '/../Entity/Feed.php';
require_once __DIR__ . '/../Entity/Item.php';

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Model\PDO\Connection;
use App\Model\DAO\FeedMapper;
use App\Model\DAO\FeedFinder;
use App\Model\DAO\ItemMapper;
use App\Model\Entity\Item;

class WorkerCommand extends Command {

    protected function configure() {
        $this->setName('Feeds worker');
        $this->setDescription('Get items for all feed');
    }

    private function isRSS($xmlFile) {
        $result = false;

        if ($xmlFile->entry)
            $result = true;

        return $result;
    }

    private function isATOM($xmlFile) {
        $result = false;

        if ($xmlFile->channel->item)
            $result = true;

        return $result;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        while (1) {
            $con = Connection::getConnection($output);
            $feedFinder = new FeedFinder($con);

            $array = $feedFinder->findAll();

            foreach ($array as $feed) {
                $link = $feed->getLink();
                $date = $feed->getDate();
                $type = $feed->getType();

                if (file_get_contents($link, 0, null, 0, 1)) {
                    $xmlFile = simplexml_load_file($link);

                    /* ---------- RSS ----------- */
                    if ($this->isRSS($xmlFile)) {
                        $items = $xmlFile->entry;

                        foreach ($items as $i) {
                            $publicationDate = date("Y-m-d H:i", strtotime($i->updated));
                            if ($date < $publicationDate) {
                                $item = new Item(
                                    $feed,
                                    $i->title,
                                    $i->link[0]['href'],
                                    $i->summary,
                                    $publicationDate
                                );

                                $itemMapper = new ItemMapper(Connection::getConnection());
                                $itemMapper->insert($item);
                            }
                        }
                    }
                    /* ---------- ATOM ---------- */
                    else if ($this->isATOM($xmlFile)) {
                        $items = $xmlFile->channel->item;

                        foreach ($items as $i) {
                            $publicationDate = date("Y-m-d H:i", strtotime($i->pubDate));
                            if ($date < $publicationDate) {
                                $item = new Item(
                                    $feed,
                                    $i->title,
                                    $i->link,
                                    explode(".", $i->description)[0],
                                    $publicationDate
                                );

                                $itemMapper = new ItemMapper(Connection::getConnection());
                                $itemMapper->insert($item);
                            }
                        }
                    }
                }

                $feed->setDate(date("Y-m-d H:i"));
                $feedMapper = new FeedMapper(Connection::getConnection());
                $feedMapper->update($feed);
            }

            $output->writeln('[' . date('Y-m-d H:i:s') . '] ' . 'New items updated.\n');
            sleep(10);
        }
    }
}
