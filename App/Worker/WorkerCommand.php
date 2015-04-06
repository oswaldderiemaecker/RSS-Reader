<?php

namespace App\Worker;

require_once __DIR__ . '/../Model/PDO/Connection.php';
require_once __DIR__ . '/../Model/DAO/FeedMapper.php';
require_once __DIR__ . '/../Model/DAO/FeedFinder.php';
require_once __DIR__ . '/../Model/DAO/ItemMapper.php';
require_once __DIR__ . '/../Model/Entity/Feed.php';
require_once __DIR__ . '/../Model/Entity/Item.php';

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use DateTime;

use App\Model\PDO\Connection;
use App\Model\DAO\FeedMapper;
use App\Model\DAO\FeedFinder;
use App\Model\DAO\ItemMapper;
use App\Model\Entity\Item;
use App\Model\Entity\FeedType;

class WorkerCommand extends Command {

    protected function configure() {
        $this->setName('check');
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

                if (file_get_contents($link, 0, null, 0, 1)) {
                    $xmlFile = simplexml_load_file($link);

                    /* ---------- RSS ----------- */
                    if ($this->isRSS($xmlFile)) {
                        $items = $xmlFile->entry;

                        $feed->setType(FeedType::RssFeed);

                        foreach ($items as $i) {
                            $publicationDate = new DateTime();
                            $publicationDate->createFromFormat('Y-m-d H:i', strtotime($i->updated));

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

                        $feed->setType(FeedType::AtomFeed);

                        foreach ($items as $i) {
                            $publicationDate = new DateTime();
                            $publicationDate->createFromFormat('Y-m-d H:i', strtotime($i->pubDate));

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

                $currentDate = new DateTime();
                $feed->setDate($currentDate);
                $feedMapper = new FeedMapper(Connection::getConnection());
                $feedMapper->update($feed);
            }

            $output->writeln('[' . $currentDate->format('Y-m-d H:i:s') . '] ' . 'New items updated.');
            sleep(10);
        }
    }
}
