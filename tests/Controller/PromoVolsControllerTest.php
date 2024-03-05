<?php

namespace App\Test\Controller;

use App\Entity\PromoVols;
use App\Repository\PromoVolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PromoVolsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PromoVolsRepository $repository;
    private string $path = '/promo/vols/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PromoVols::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PromoVol index');

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
            'promo_vol[pourcentage]' => 'Testing',
            'promo_vol[dateDebutPromo]' => 'Testing',
            'promo_vol[dateFinPromo]' => 'Testing',
        ]);

        self::assertResponseRedirects('/promo/vols/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PromoVols();
        $fixture->setPourcentage('My Title');
        $fixture->setDateDebutPromo('My Title');
        $fixture->setDateFinPromo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PromoVol');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PromoVols();
        $fixture->setPourcentage('My Title');
        $fixture->setDateDebutPromo('My Title');
        $fixture->setDateFinPromo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'promo_vol[pourcentage]' => 'Something New',
            'promo_vol[dateDebutPromo]' => 'Something New',
            'promo_vol[dateFinPromo]' => 'Something New',
        ]);

        self::assertResponseRedirects('/promo/vols/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPourcentage());
        self::assertSame('Something New', $fixture[0]->getDateDebutPromo());
        self::assertSame('Something New', $fixture[0]->getDateFinPromo());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PromoVols();
        $fixture->setPourcentage('My Title');
        $fixture->setDateDebutPromo('My Title');
        $fixture->setDateFinPromo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/promo/vols/');
    }
}
