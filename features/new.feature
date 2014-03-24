Feature: Creating new objects using the CRUD
  In order to administer using the crudify bundle
  As a user
  I need to be able to create new objects


  Scenario: I should be able to visit the create page
    Given I am on the users index page
    When I follow "Add"
    Then I should be on the new user page
    And I should see "Add Users"

  Scenario: When adding a correct user, I should see it in the list of users
    Given the following users exist:
      | name  | city        | street        | enabled |
      | Joe   | Idaho Falls | Ultricies Rd. | yes     |
      | John  | Arviat      | Morbi Avenue  | no      |
    And I am on the new user page
    When I fill in "Name" with "Judy"
    And I fill in "City" with "Amsterdam"
    And I fill in "Street" with "Homestreet"
    And I press "Save"
    Then I should be on the users index page
    And I should see "The object was created."
    And I should see a grid with 3 rows
    And I should see "Judy" in row 3
    And I should see "Amsterdam" in row 3
    And I should see "Homestreet" in row 3
    And I should see "No" in row 3

  Scenario: When adding an incorrect user, it should not be saved
    Given I am on the new user page
    When I press "Save"
    Then I should be on the create user page
    And I should see "There were errors on the form."
    When I go to the users index page
    Then I should see a grid with 0 rows

  Scenario: Saving and continuing to edit should remain on the same page
    Given I am on the new user page
    When I fill in "Name" with "Judy"
    And I fill in "City" with "Amsterdam"
    And I fill in "Street" with "Homestreet"
    And I press "Save and Continue Editing"
    Then I should be on the user edit page for "Judy"
    And the "City" field should contain "Amsterdam"
    And I should see "The object was created."
    When I go to the user index page
    Then I should see a grid with 1 row
