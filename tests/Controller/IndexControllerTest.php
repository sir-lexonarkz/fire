<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Source;
use App\Repository\SourceRepository;

class IndexControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private SourceRepository $repository;
    private string $path = '/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $hostname = $this->client->getContainer()->getParameter('fire.test.hostname');
        $https = $this->client->getContainer()->getParameter('fire.test.https');
        $this->client->setServerParameter('HTTP_HOST', $hostname );
        $this->client->setServerParameter('HTTPS', $https );
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Source::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }
    
    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('FIRe');
        self::assertSelectorTextContains('h1', 'Welcome');

    }

    public function testRemove(): void
    {
        $fixture = new Source();
        $fixture->setName('Value');
        $fixture->setUrl('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', $this->path);
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/');
        self::assertSame(0, $this->repository->count([]));
    }
}
