<?php

namespace Bs\CrudifyBundle\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Exception\PendingException;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use Behat\Mink\WebAssert;
use Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;

trait EditContext
{
    /**
     * @return DocumentElement
     */
    abstract public function getPage();

    /**
     * @param string $name
     * @return Session
     */
    abstract public function getSession($name = null);

    /**
     * @param string $path
     * @return string
     */
    abstract public function locatePath($path);

    /**
     * @param string $name
     * @return WebAssert
     */
    abstract public function assertSession($name = null);

    /**
     * @return Registry
     */
    abstract public function getDoctrine();

    /**
     * @Then /^I should be on the new user page$/
     */
    public function iShouldBeOnTheNewUserPage()
    {
        $this->assertSession()->addressEquals($this->locatePath("/users/new"));
        $this->assertSession()->pageTextContains('Add Users');
    }

    /**
     * @Then /^I should be on the create user page$/
     */
    public function iShouldBeOnTheCreateUserPage()
    {
        $this->assertSession()->addressEquals($this->locatePath("/users"));
        $this->assertSession()->pageTextContains('Add Users');
    }

    /**
     * @Given /^I am on the new user page$/
     */
    public function iAmOnTheNewUserPage()
    {
        $this->getSession()->visit($this->locatePath("/users/new"));
    }

    /**
     * @Then /^I should be on the user edit page for "([^"]*)"$/
     * @Then /^I should be on the user update page for "([^"]*)"$/
     * @Then /^I should be on the edit page for user "([^"]*)"$/
     */
    public function iShouldBeOnTheUserEditPageFor($username)
    {
        $user = $this->getUserByName($username);
        $this->assertSession()->addressEquals("/users/{$user->getId()}");
    }

    /**
     * @Given /^I am on the user edit page for "([^"]*)"$/
     * @Given /^I am on the edit page for user "([^"]*)"$/
     */
    public function iAmOnTheUserEditPageFor($username)
    {
        $user = $this->getUserByName($username);
        $this->getSession()->visit($this->locatePath("/users/{$user->getId()}"));
    }

    /**
     * @param string $name
     * @return User
     */
    public function getUserByName($name)
    {
        return $this->getDoctrine()->getRepository('TestBundle:User')->findOneBy([
            'name' => $name,
        ]);
    }

    /**
     * @Given /^I should see a delete button$/
     */
    public function iShouldSeeADeleteButton()
    {
        $button = $this->getPage()->findButton("Delete");
        Assertion::notNull($button, "There is no delete button");
    }

    /**
     * @When /^I press the delete button$/
     */
    public function iPressTheDeleteButton()
    {
        $button = $this->getPage()->findButton("Delete");
        Assertion::notNull($button);
        $button->click();
    }
}
