<?php
///**
// * Created by PhpStorm.
// * User: agafonova
// * Date: 04.12.17
// * Time: 12:10
// */

namespace App\Services;

//require_once '/vendor/autoload.php';
use Google_Service_Books;


class GoogleBooksSearch
{
    public $service;

    public function __construct()
    {
        $client = new \Google_Client();
        $client->setApplicationName(config("google_project"));
        $client->setDeveloperKey(config("google_key"));

        $this->service = new \Google_Service_Books($client);
    }

    public function getBooks($field)
    {
        $optParams = array('filter' => 'free-ebooks');
        $results = $this->service->volumes->listVolumes($field, $optParams)->getItems();

//        dd($results);
        return $results;
    }
}