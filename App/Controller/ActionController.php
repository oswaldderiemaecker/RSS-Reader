<?php

namespace App\Controller;

require_once __DIR__ . '/../Model/PDO/Connection.php';
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
    public function index(Application $app) {
        $con = Connection::getConnection();
        $itemFinder = new ItemFinder($con);

        $items = $sliced_array = array_slice($itemFinder->findAll(), 0, 10);

        return $app["twig"]->render(
            "index.twig",
            array("items" => $items)
        );
    }

    public function feeds(Application $app) {
        $con = Connection::getConnection();
        $feedFinder = new FeedFinder($con);

        $feeds = $sliced_array = array_slice($feedFinder->findAll(), 0, 10);

        return $app["twig"]->render(
            "feeds.twig",
            array("feeds" => $feeds)
        );
    }

    public function feed(Application $app) {
        $form = $app["twig"]->createFormBuilder()
            ->add('title', 'text')
            ->getForm();

        return $app["twig"]->render(
            "feed.twig",
            array("form" => $form->createView())
        );
    }

    public function addFeed(Request $request) {
        $con = Connection::getConnection();
        $feedMapper = new FeedMapper($con);

        $title = $request->get("title");
        $link = $request->get("link");
        $description = $request->get("description");
        $type = $request->get("type");

        if (!filter_var($link, FILTER_VALIDATE_URL) == false) {
            $feed = new Feed($title, $link, $description, new DateTime(), $type);
            $feedMapper->insert($feed);
        }
    }

    public function deleteFeed(Request $request) {
        $con = Connection::getConnection();
        $feedMapper = new FeedMapper($con);
        $feedFinder = new FeedFinder($con);

        $id = $request->get("id");

        $feed = $feedFinder->find($id);
        $feedMapper->delete($feed);
    }

    public function connect(Application $app) {
        $index = $app['controllers_factory'];
        $index->match("/", 'App\Controller\ActionController::index')->bind("index");
        $index->match("/feeds", 'App\Controller\ActionController::feeds')->bind("feeds");
        $index->match("/addFeed", 'App\Controller\ActionController::addFeed')->bind("addFeed");
        $index->match("/deleteFeed", 'App\Controller\ActionController::deleteFeed')->bind("deleteFeed");
        return $index;
    }
}
