Feature: Creating new objects using the CRUD
  In order to administer using the crudify bundle
  As a user
  I need to be able to create new objects


  Scenario: I should be able to visit the create page
    Given I am on "/users"
    When I follow "Add"
    Then I should be on "/users/new"
    And I should see "Add user"

  Scenario: When adding a correct user, I should see it in the list of users
    Given the following users exist:
      | name  | city        | street        | enabled |
      | Joe   | Idaho Falls | Ultricies Rd. | yes     |
      | John  | Arviat      | Morbi Avenue  | no      |
    And I am on "/users/new"
    When I fill in "Name" with "Judy"
    And I fill in "City" with "Amsterdam"
    And I fill in "Street" with "Homestreet"
    And I press "Save"
    Then I should be on "/users"
    And I should see a grid with 3 rows
    And I should see "Judy" in row 3
    And I should see "Amsterdam" in row 3
    And I should see "Homestreet" in row 3
    And I should see "No" in row 3
