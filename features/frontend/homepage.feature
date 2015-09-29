@homepage
Feature: CMS Homepage
    In order to view the website
    As a visitor
    I want to be able to see the homepage

    Scenario: Viewing the homepage at website root
        Given website has default configuration
         When I go to the website root
         Then I should be on the homepage
          And I should see "Welcome to My Wonderful Website!"
          And the response status code should be 200
