<?php

namespace Bs\CrudifyBundle\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Exception\PendingException;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;

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
        Assertion::same(count($columns), (int) $count);
    }

    /**
     * @Then /^I should see a grid with (\d+) rows$/
     */
    public function iShouldSeeAGridWithRows($count)
    {
        $rows = $this->getPage()->findAll('css', '.crudify-grid > tbody > tr');
        Assertion::same(count($rows), (int) $count);
    }

    /**
     * @Then /^there should be pagination on the page$/
     */
    public function thereShouldBePaginationOnThePage()
    {
        Assertion::notNull($this->getPage()->find('css', 'ul.pagination'));
    }

    /**
     * @Then /^I should be on the second users page$/
     */
    public function iShouldBeOnTheSecondUsersPage()
    {
        Assertion::contains($this->getSession()->getCurrentUrl(), 'page=2');
    }

    /**
     * @Then /^I should see "([^"]*)" in row (\d+)$/
     */
    public function iShouldSeeInRow($what, $row)
    {
        $row = ((int) $row) - 1;
        $rows = $this->getPage()->findAll('css', '.crudify-grid > tbody > tr');
        Assertion::min(count($rows), $row);

        /** @var NodeElement $r */
        $r = $rows[$row];
        Assertion::contains($r->getText(), $what);
    }
}
