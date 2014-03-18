Feature: Visiting the index page
  In order to be able to administer using the CRUD
  As a user
  I need to be able to view the list of objects

  Background:
    Given the following users exist:
      | name  | city        | street        |
      | Joe   | Idaho Falls | Ultricies Rd. |
      | John  | Arviat      | Morbi Avenue  |
      | Julia | Hallaar     | Nec, Street   |
      | Jane  | Tulita      | Ipsum St.     |

  Scenario: Getting redirected to the default mapping
    When I am on the homepage
    Then I should be on "/users"

  Scenario:
    When I am on "/users"
    Then I should see "Joe"
    And I should see "Jane"
    And I should see "Arviat"
    And I should see "Nec, Street"
