<?php

namespace App\Test\Controller;

use App\Entity\Gender;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GenderControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/gender/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Gender::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gender index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'gender[terror]' => 'Testing',
            'gender[suspense]' => 'Testing',
            'gender[comedy]' => 'Testing',
            'gender[cartoon]' => 'Testing',
            'gender[anime]' => 'Testing',
            'gender[drama]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gender();
        $fixture->setTerror('My Title');
        $fixture->setSuspense('My Title');
        $fixture->setComedy('My Title');
        $fixture->setCartoon('My Title');
        $fixture->setAnime('My Title');
        $fixture->setDrama('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gender');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gender();
        $fixture->setTerror('Value');
        $fixture->setSuspense('Value');
        $fixture->setComedy('Value');
        $fixture->setCartoon('Value');
        $fixture->setAnime('Value');
        $fixture->setDrama('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'gender[terror]' => 'Something New',
            'gender[suspense]' => 'Something New',
            'gender[comedy]' => 'Something New',
            'gender[cartoon]' => 'Something New',
            'gender[anime]' => 'Something New',
            'gender[drama]' => 'Something New',
        ]);

        self::assertResponseRedirects('/gender/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTerror());
        self::assertSame('Something New', $fixture[0]->getSuspense());
        self::assertSame('Something New', $fixture[0]->getComedy());
        self::assertSame('Something New', $fixture[0]->getCartoon());
        self::assertSame('Something New', $fixture[0]->getAnime());
        self::assertSame('Something New', $fixture[0]->getDrama());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gender();
        $fixture->setTerror('Value');
        $fixture->setSuspense('Value');
        $fixture->setComedy('Value');
        $fixture->setCartoon('Value');
        $fixture->setAnime('Value');
        $fixture->setDrama('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/gender/');
        self::assertSame(0, $this->repository->count([]));
    }
}
