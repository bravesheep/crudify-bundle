Feature: Visiting the index page
  In order to be able to administer using the CRUD
  As a user
  I need to be able to view the list of objects

  Scenario: Viewing the website root
    Given I am on the homepage
     Then I should be on "/users"
