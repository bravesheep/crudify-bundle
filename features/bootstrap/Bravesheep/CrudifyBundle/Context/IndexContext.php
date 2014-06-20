<?php

namespace Bravesheep\CrudifyBundle\Context;

use Behat\Behat\Exception\PendingException;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use Behat\Mink\WebAssert;

trait IndexContext
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
     * @When /^I click on the next page button$/
     */
    public function iClickOnTheNextPageButton()
    {
        $this->getPage()->findLink('Next »')->click();
    }

    /**
     * @Then /^there should be (\d+) columns in the grid$/
     */
    public function thereShouldBeColumnsInTheGrid($count)
    {
        $columns = $this->getPage()->findAll('css', '.crudify-grid > thead > tr > th');
        expect($columns)->toHaveCount((int) $count);
    }

    /**
     * @Then /^I should see a grid with (\d+) rows$/
     * @Then /^I should see a grid with (\d+) row$/
     */
    public function iShouldSeeAGridWithRows($count)
    {
        $rows = $this->getPage()->findAll('css', '.crudify-grid > tbody > tr');
        expect($rows)->toHaveCount((int) $count);
    }

    /**
     * @Then /^there should be pagination on the page$/
     */
    public function thereShouldBePaginationOnThePage()
    {
        expect($this->getPage()->find('css', 'ul.pagination'))->notToBeNull();
    }

    /**
     * @Then /^I should be on the second users page$/
     */
    public function iShouldBeOnTheSecondUsersPage()
    {
        expect(strpos($this->getSession()->getCurrentUrl(), 'page=2'))->notToBe(false);
    }

    /**
     * @Then /^I should see "([^"]*)" in row (\d+)$/
     */
    public function iShouldSeeInRow($what, $row)
    {
        $row = ((int) $row) - 1;
        $rows = $this->getPage()->findAll('css', '.crudify-grid > tbody > tr');
        expect(count($rows) > $row)->toBe(true);

        /** @var NodeElement $r */
        $r = $rows[$row];
        expect(strpos($r->getText(), $what))->notToBe(false);
    }

    /**
     * @Then /^I should be on the users index page$/
     * @Then /^I should be on the user index page$/
     */
    public function iShouldBeOnTheUsersIndexPage()
    {
        $this->assertSession()->addressEquals($this->locatePath("/users"));
        $this->assertSession()->pageTextContains('Overview users');
    }

    /**
     * @Given /^I am on the users index page$/
     * @when /^I go to the users index page$/
     * @When /^I go to the user index page$/
     * @Given /^I am on the user index page$/
     */
    public function iAmOnTheUsersIndexPage()
    {
        $this->getSession()->visit($this->locatePath("/users"));
    }

    /**
     * @When /^I follow "([^"]*)" in row (\d+)$/
     */
    public function iFollowInRow($link, $rowNum)
    {
        $elem = $this->getPage()->find('css', '.crudify-grid > tbody > tr:nth-child(' . $rowNum . ')');
        expect($elem)->notToBeNull();
        $elem->clickLink($link);
    }
}
