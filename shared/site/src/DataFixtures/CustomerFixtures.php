<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{

    private $data = [
        "John",
        "Jack",
        "Ripper"
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $customer = new Customer();
            $customer->setName($data);
            $manager->persist($customer);
        }

        $manager->flush();
    }
}