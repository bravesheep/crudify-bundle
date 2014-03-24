Feature: Modifying existing objects using the CRUD
  In order to administer using the crudify bundle
  As a user
  I need to be able to edit existing objects

  Background:
    Given the following users exist:
      | name  | city        | street        | enabled |
      | Joe   | Idaho Falls | Ultricies Rd. | yes     |
      | John  | Arviat      | Morbi Avenue  | no      |

  Scenario: I should be able to go to the edit page
    Given I am on the user index page
    When I follow "Edit" in row 1
    Then I should be on the user edit page for "Joe"

  Scenario: I should be able to edit an object
    Given I am on the user edit page for "Joe"
    When I fill in "City" with "Amsterdam"
    And I fill in "Street" with "Roadyst."
    And I uncheck "Enabled"
    And I press "Save"
    Then I should be on the user index page
    And I should see "The object was updated."
    And I should see a grid with 2 rows
    And I should see "Joe" in row 1
    And I should see "Amsterdam" in row 1
    And I should see "Roadyst." in row 1
    And I should see "No" in row 1

  Scenario: An invalid object should not be saved
    Given I am on the user edit page for "John"
    When I fill in "City" with ""
    And I press "Save"
    Then I should be on the user update page for "John"
    And I should see "There were errors on the form."
    When I go to the user index page
    Then I should see a grid with 2 rows
    And I should see "Arviat" in row 2

  Scenario: Saving and continuing to edit should remain on the same page
    Given I am on the user edit page for "Joe"
    And I fill in "City" with "Amsterdam"
    And I press "Save and Continue Editing"
    Then I should be on the user edit page for "Joe"
    And the "City" field should contain "Amsterdam"
    And I should see "The object was updated."
