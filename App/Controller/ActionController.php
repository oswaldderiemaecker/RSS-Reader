<?php

namespace App\Controller;

require_once __DIR__ . '/../Model/PDO/Connection.php';
require_once __DIR__ . '/../Model/DAO/FeedMapper.php';
require_once __DIR__ . '/../Model/DAO/FeedFinder.php';
require_once __DIR__ . '/../Model/DAO/ItemMapper.php';
require_once __DIR__ . '/../Model/DAO/ItemFinder.php';
require_once __DIR__ . '/../Model/Entity/Item.php';

use App\Model\PDO\Connection;
use App\Model\DAO\ItemFinder;
use App\Model\DAO\FeedFinder;
use App\Model\DAO\FeedMapper;
use App\Model\Entity\Feed;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ActionController implements ControllerProviderInterface
{
    /**
     * Renvoie la liste des items.
     *
     * @param Application $app  Application Silex
     * @return mixed            La page web avec la liste des items
     */
    public function index(Application $app) {
        $con = Connection::getConnection();
        $itemFinder = new ItemFinder($con);

        $items = array_slice($itemFinder->findAll(), 0, 50);

        return $app["twig"]->render(
            "index.twig",
            array("items" => $items)
        );
    }

    /**
     * Renvoie la liste des flux.
     *
     * @param Application $app  Application Silex
     * @return mixed            La page web avec la liste des flux
     */
    public function showFeeds(Application $app) {
        $con = Connection::getConnection();
        $feedFinder = new FeedFinder($con);

        $feeds = array_slice($feedFinder->findAll(), 0, 50);

        return $app["twig"]->render(
            "feeds.twig",
            array("feeds" => $feeds)
        );
    }

    /**
     * Renvoie la liste des items au format JSON.
     *
     * @param Application $app  Application Silex
     * @return string           La liste des items au format JSON
     */
    public function items(Application $app) {
        $con = Connection::getConnection();
        $itemFinder = new ItemFinder($con);

        $items = array_slice($itemFinder->findAll(), 0, 50);
        $result = array();

        foreach ($items as $item) {
            $i = array(
                'id' => $item->getId(),
                'idFeed' => $item->getFeed()->getId(),
                'title' => $item->getTitle(),
                'link' => $item->getLink(),
                'description' => $item->getDescription(),
                'date' => $item->getDate()->format('Y-m-d H:i:s')
            );

            array_push($result, $i);
        }

        return json_encode($result);
    }

    /**
     * Renvoie la liste des flux au format JSON.
     *
     * @param Application $app  Application Silex
     * @return string           La liste des flux au format JSON
     */
    public function feeds(Application $app) {
        $con = Connection::getConnection();
        $feedFinder = new FeedFinder($con);

        $feeds = array_slice($feedFinder->findAll(), 0, 50);
        $result = array();

        foreach ($feeds as $feed) {
            $i = array(
                'id' => $feed->getId(),
                'title' => $feed->getTitle(),
                'link' => $feed->getLink(),
                'description' => $feed->getDescription(),
                'date' => $feed->getDate()->format('Y-m-d H:i:s'),
                'type' => $feed->getType()
            );

            array_push($result, $i);
        }

        return json_encode($result);
    }

    /**
     * Ajoute un flux.
     *
     * @param Application $app  Application Silex
     * @param $title            Titre du flux
     * @param $link             Lien du flux
     * @param $description      Description du flux
     */
    public function addFeed(Application $app, $title, $link, $description) {
        $con = Connection::getConnection();
        $feedMapper = new fFeedMapper($con);

        if (!filter_var($link, FILTER_VALIDATE_URL) == false) {
            $feed = new Feed($title, $link, $description, new DateTime(), 0);
            $feedMapper->insert($feed);
        }
    }

    /**
     * Supprime un flux à partir de l'id.
     *
     * @param Application $app  Application Silex
     * @param $id               L'id du flux
     */
    public function deleteFeed(Application $app, $id) {
        $con = Connection::getConnection();
        $feedMapper = new FeedMapper($con);
        $feedFinder = new FeedFinder($con);

        $feed = $feedFinder->find($id);
        $feedMapper->delete($feed);
    }

    public function connect(Application $app) {
        $index = $app['controllers_factory'];
        $index->match("/", 'App\Controller\ActionController::index')->bind("index");
        $index->match("/show-feeds", 'App\Controller\ActionController::showFeeds')->bind("show-feeds");

        $index->get("/feeds", 'App\Controller\ActionController::feeds');
        $index->get("/items", 'App\Controller\ActionController::items');
        $index->post("/addFeed{title}{link}{description}", 'App\Controller\ActionController::addFeed');
        $index->delete("/deleteFeed{id}", 'App\Controller\ActionController::deleteFeed');

        return $index;
    }
}
