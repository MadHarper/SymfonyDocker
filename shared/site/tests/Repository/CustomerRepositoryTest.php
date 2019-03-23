<?php

namespace App\Tests\Repository;

use App\DataFixtures\CustomerFixtures;
use App\Repository\CustomerRepository;
use App\Tests\FixtureAwareTestCase;
use Doctrine\ORM\EntityManager;
use App\Entity\Customer;

class CustomerRepositoryTest extends FixtureAwareTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    protected function setUp()
    {
        parent::setUp();

        // Define the fixtures to be loaded. We will request to load in our 5 products
        $this->addFixture(new CustomerFixtures());

        // This will purge the test database and load in all the requested fixtures
        $this->executeFixtures();

        // Boot up the Symfony Kernel
        $kernel = static::bootKernel();

        // Lets get the entityManager from the container
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();


        //$this->customerRepository = new CustomerRepository($this->entityManager);
        $this->customerRepository = $this->entityManager->getRepository(Customer::class);
    }

    public function testFind(): void
    {
        $customer = $this->customerRepository->findOneBy(['name' => 'John']);
        $this->assertEquals('John', $customer->getName());
    }
}