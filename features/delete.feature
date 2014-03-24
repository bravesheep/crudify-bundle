Feature: Deleting existing objects using the CRUD
  In order to administer using the crudify bundle
  As a user
  I need to be able to delete existing objects

  Background:
    Given the following users exist:
      | name  | city        | street        | enabled |
      | Joe   | Idaho Falls | Ultricies Rd. | yes     |
      | John  | Arviat      | Morbi Avenue  | no      |

  Scenario: I want to see the delete button
    Given I am on the user index page
    When I follow "Edit" in row 1
    Then I should be on the edit page for user "Joe"
    And I should see a delete button

  Scenario: When deleting an object, it should be removed
    Given I am on the edit page for user "Joe"
    When I press the delete button
    Then I should be on the user index page
    And I should see "The object was removed."
    And I should see a grid with 1 row
