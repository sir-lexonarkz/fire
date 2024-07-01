<?php

namespace App\Tests\Controller;

use App\Entity\Source;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SourceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/source/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $hostname = $this->client->getContainer()->getParameter('myapp.test.hostname');
        $this->client->setServerParameter('HTTP_HOST', $hostname );
        $this->client->setServerParameter('HTTPS', 'on' );
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Source::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Source();
        $fixture->setName('Value');
        $fixture->setUrl('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/');
        self::assertSame(0, $this->repository->count([]));
    }
}
