<?php

namespace App\Service;

use SimpleXMLElement;

class XMLImporter
{

    /**
     * The function `xmlImporterFeed` loads an XML file from a given URL and returns the channel
     * element as a SimpleXMLElement or an error message if loading fails.
     * @param string $url The `url` parameter in the `xmlImporterFeed` function is a string that
     * represents the URL from which an XML feed will be imported. This function attempts to load the
     * XML file from the provided URL using `simplexml_load_file` function. If successful, it returns
     * the SimpleXMLElement object representing
     * @return SimpleXMLElement|array<string, string>|false The function `xmlImporterFeed` will return a SimpleXMLElement
     * object if the XML file at the provided URL can be loaded successfully using
     * `simplexml_load_file`. If an error occurs during loading, it will return an associative array
     * with keys 'type' and 'message' containing information about the error. If the XML file is loaded
     * successfully, it will return the 'channel' element of the feed.
     */
    public function xmlImporterFeed(string $url): SimpleXMLElement|array|false
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
