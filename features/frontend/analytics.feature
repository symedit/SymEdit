@analytics
Feature: Analytics Tracking
    In order to track views on objects
    I want to be able record when they are shown

    Scenario: Tracking Regular CMS Page
        Given I am on the homepage
         Then I should have a tracked page

    Scenario: Tracking a page controller page
        Given I am on the blog index
         Then I should have a tracked page

    Scenario: Tracking a post and not counting page controller
        Given I am on the blog index
          And I follow "Hello World!"
         Then I should have a tracked post
          And I should not have a tracked page