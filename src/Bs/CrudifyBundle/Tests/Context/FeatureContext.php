<?php

namespace Bs\CrudifyBundle\Tests\Context;

use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\DocumentElement;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Entity\Address;
use Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;

class FeatureContext extends MinkContext
{
    use KernelDictionary;
    use IndexContext;
    use EditContext;

    /**
     * @return DocumentElement
     */
    public function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @Given /^the following users exist:$/
     */
    public function theFollowingUsersExist(TableNode $table)
    {
        $em = $this->getDoctrine()->getManager();

        $hash = $table->getHash();
        foreach ($hash as $row) {
            $user = new User();
            $address = new Address();
            $address->setCity($row['city']);
            $address->setStreet($row['street']);
            $user->setName($row['name']);
            $user->setAddress($address);
            $user->setEnabled(strtolower($row['enabled']) === 'yes');
            $em->persist($address);
            $em->persist($user);
        }
        $em->flush();
    }

    /**
     * @Given /^there are (\d+) users$/
     */
    public function thereAreUsers($count)
    {
        $faker = \Faker\Factory::create();
        $em = $this->getDoctrine()->getManager();

        for ($i = 0; $i < (int) $count; $i += 1) {
            $user = new User();
            $address = new Address();
            $address->setCity($faker->city);
            $address->setStreet($faker->streetName);
            $user->setName($faker->firstName);
            $user->setAddress($address);
            $user->setEnabled($faker->boolean());
            $em->persist($address);
            $em->persist($user);
        }
        $em->flush();
    }
}
