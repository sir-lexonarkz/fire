<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\XMLImporter;
use SimpleXMLElement;

class SourceControllerTest extends TestCase
{


    public function testXmlFeedImporter(): void
    {
        $feed = new XMLImporter;
        $feed_importer = $feed->xmlImporterFeed('https://www.lemonde.fr/rss/une.xml');
        $this->assertInstanceOf(SimpleXMLElement::class, $feed_importer);
    }
}
