Feature: Visiting the index page
  In order to be able to administer using the CRUD
  As a user
  I need to be able to view the list of objects

  Scenario: Getting redirected to the default mapping
    When I am on the homepage
    Then I should be on "/users"

  Scenario: I should be able to see the information in the user table
    Given the following users exist:
      | name  | city        | street        |
      | Joe   | Idaho Falls | Ultricies Rd. |
      | John  | Arviat      | Morbi Avenue  |
      | Julia | Hallaar     | Nec, Street   |
      | Jane  | Tulita      | Ipsum St.     |
    When I am on "/users"
    Then I should see a grid with 4 rows
    And I should see "Joe"
    And I should see "Arviat"
    And I should see "Nec, Street"

  Scenario: Pagination should be visible if there are many users
    Given there are 30 users
    When I am on "/users"
    Then there should be pagination on the page

  Scenario: I should be able to visit the second page of results
    Given there are 30 users
    When I am on "/users"
    And I click on the next page button
    Then I should be on the second users page
    And I should see a grid with 10 rows

