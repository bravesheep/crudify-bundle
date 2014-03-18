<?php

namespace Bs\CrudifyBundle\Tests\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Entity\Address;
use Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class FeatureContext extends MinkContext
{
    use KernelDictionary;

    /**
     * @Given /^the following users exist:$/
     */
    public function theFollowingUsersExist(TableNode $table)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManagerForClass('TestBundle:User');

        $hash = $table->getHash();
        foreach ($hash as $row) {
            $user = new User();
            $address = new Address();
            $address->setCity($row['city']);
            $address->setStreet($row['street']);
            $user->setName($row['name']);
            $user->setAddress($address);
            $em->persist($address);
            $em->persist($user);
        }
        $em->flush();
    }
}
