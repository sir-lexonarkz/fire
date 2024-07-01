<?php

namespace App\Service;

use SimpleXMLElement;

class XMLImporter
{
    /**
     * This PHP function loads an XML feed from a specified URL and returns the channel element as a
     * SimpleXMLElement object or false if the feed cannot be loaded.
     * 
     * @param url The `url` parameter in the `xmlImporterFeed` function is expected to be a string
     * representing the URL of an XML feed that you want to import. This function uses
     * `simplexml_load_file` to load the XML file from the provided URL and then returns the `channel`
     * element of the
     * 
     * @return SimpleXMLElement|false The function `xmlImporterFeed` is returning a `SimpleXMLElement`
     * object if the XML file is successfully loaded from the provided URL. If there is an issue
     * loading the file, it will return `false`.
     */
    public function xmlImporterFeed($url): SimpleXMLElement|array
    {
        $feed = false;
        try {
            $feed = simplexml_load_file($url);
        } catch (\Throwable $th) {
            return ['type' => 'error', 'message' => $th];
        }
        if ($feed) {
            $feed = $feed->channel;
        }
        return $feed;
    }
}
