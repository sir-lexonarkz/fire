<?php 

namespace App\Service;

use SimpleXMLElement;

class XMLImporter
{
    public function XMLImporterFeed($url): SimpleXMLElement|false
    {
        $feed = simplexml_load_file($url);
        if($feed) {
            $feed = $feed->channel;
        }
        return $feed;
    }
}