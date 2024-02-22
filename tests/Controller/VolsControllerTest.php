<?php

namespace App\Test\Controller;

use App\Entity\Vols;
use App\Repository\VolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VolsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private VolsRepository $repository;
    private string $path = '/vols/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Vols::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vol index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'vol[duree]' => 'Testing',
            'vol[datedepart]' => 'Testing',
            'vol[datearrive]' => 'Testing',
            'vol[nbrescale]' => 'Testing',
            'vol[nbrplace]' => 'Testing',
            'vol[classe]' => 'Testing',
            'vol[destination]' => 'Testing',
            'vol[pointdepart]' => 'Testing',
            'vol[prix]' => 'Testing',
        ]);

        self::assertResponseRedirects('/vols/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vols();
        $fixture->setDuree('My Title');
        $fixture->setDatedepart('My Title');
        $fixture->setDatearrive('My Title');
        $fixture->setNbrescale('My Title');
        $fixture->setNbrplace('My Title');
        $fixture->setClasse('My Title');
        $fixture->setDestination('My Title');
        $fixture->setPointdepart('My Title');
        $fixture->setPrix('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vol');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vols();
        $fixture->setDuree('My Title');
        $fixture->setDatedepart('My Title');
        $fixture->setDatearrive('My Title');
        $fixture->setNbrescale('My Title');
        $fixture->setNbrplace('My Title');
        $fixture->setClasse('My Title');
        $fixture->setDestination('My Title');
        $fixture->setPointdepart('My Title');
        $fixture->setPrix('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'vol[duree]' => 'Something New',
            'vol[datedepart]' => 'Something New',
            'vol[datearrive]' => 'Something New',
            'vol[nbrescale]' => 'Something New',
            'vol[nbrplace]' => 'Something New',
            'vol[classe]' => 'Something New',
            'vol[destination]' => 'Something New',
            'vol[pointdepart]' => 'Something New',
            'vol[prix]' => 'Something New',
        ]);

        self::assertResponseRedirects('/vols/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDuree());
        self::assertSame('Something New', $fixture[0]->getDatedepart());
        self::assertSame('Something New', $fixture[0]->getDatearrive());
        self::assertSame('Something New', $fixture[0]->getNbrescale());
        self::assertSame('Something New', $fixture[0]->getNbrplace());
        self::assertSame('Something New', $fixture[0]->getClasse());
        self::assertSame('Something New', $fixture[0]->getDestination());
        self::assertSame('Something New', $fixture[0]->getPointdepart());
        self::assertSame('Something New', $fixture[0]->getPrix());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Vols();
        $fixture->setDuree('My Title');
        $fixture->setDatedepart('My Title');
        $fixture->setDatearrive('My Title');
        $fixture->setNbrescale('My Title');
        $fixture->setNbrplace('My Title');
        $fixture->setClasse('My Title');
        $fixture->setDestination('My Title');
        $fixture->setPointdepart('My Title');
        $fixture->setPrix('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/vols/');
    }
}
