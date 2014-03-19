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
            $em->persist($address);
            $em->persist($user);
        }
        $em->flush();
    }

    /**
     * @Then /^I should see a grid with (\d+) rows$/
     */
    public function iShouldSeeAGridWithRows($count)
    {
        $rows = $this->getPage()->findAll('css', '.crudify-grid > tbody > tr');
        expect(count($rows))->toBe((int) $count);
    }

    /**
     * @Then /^there should be pagination on the page$/
     */
    public function thereShouldBePaginationOnThePage()
    {
        expect($this->getPage()->find('css', 'ul.pagination'))->notToBe(null);
    }

    /**
     * @When /^I click on the next page button$/
     */
    public function iClickOnTheNextPageButton()
    {
        $this->getPage()->findLink('Next »')->click();
    }

    /**
     * @Then /^I should be on the second users page$/
     */
    public function iShouldBeOnTheSecondUsersPage()
    {
        expect($this->getSession()->getCurrentUrl())->toMatch('/page=2/');
    }
}
