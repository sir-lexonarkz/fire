<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/* The `class ApiContext` is defining a PHP class named `ApiContext` that extends `WebTestCase` and
implements the `Context` interface. This class is used in Behat testing scenarios to define
context-specific methods and properties that can be used in the test scenarios. In this specific
case, the `ApiContext` class is responsible for preparing the database schema before running a Behat
feature by dropping the existing database and creating a new schema based on the entity metadata. */
class ApiContext extends WebTestCase implements Context
{

    /**
     *  @BeforeFeature 
     **/
    public static function prepareForTheFeature(): void
    {
        $manager = static::getContainer()->get('doctrine')->getManager();
        $metaData = $manager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($manager);
        $schemaTool->dropDatabase();
        if (!empty($metaData)) {
            $schemaTool->createSchema($metaData);
        }
    }
}
