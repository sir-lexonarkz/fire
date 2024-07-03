<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class ApiContext extends WebTestCase implements Context
{

    private EntityManagerInterface $manager;

    /**
     * FeatureContext constructor.
     * @param ContainerInterface $container
     * @param EntityManager $entityManager
     */
    public function __construct()
    {
    }

    protected function setupDatabase()
    {
        $metaData = $this->manager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->manager);
        $schemaTool->dropDatabase();
        if (!empty($metaData)) {
            $schemaTool->createSchema($metaData);
        }
    }

    /** @BeforeFeature */
    public static function prepareForTheFeature()
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
