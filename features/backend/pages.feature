@pages
Feature: Page Backend
    In order to manage the pages
    As an administrator
    I want to be able to list, view, edit and create pages

    Background:
        Given I am logged in as admin

    Scenario: Seeing index of all pages
        Given I am on the admin dashboard page
         When I follow "List Pages"
         Then I should be on the admin page page
          And I should see 5 page in the list

    Scenario: Accessing page create form
        Given I am on the admin dashboard page
         When I follow "New Page"
         Then I should be on the admin page create page
          And I should see "Create New Page"

    Scenario: Creating a simple page
        Given I am on the admin page create page
         When I fill in "symedit_page_basic_title" with "Here is a test page"
          And I fill in "symedit_page_basic_name" with "here-is-a-test-page"
          And I press "Create Page"
         Then I should have a page resource with name "here-is-a-test-page"
          And I should see "Page has been successfully created."

    Scenario: Adding a child should prepend parent slug
        Given I am on the admin page create page
         When I fill in "symedit_page_basic_title" with "Here is a child page"
          And I fill in "symedit_page_basic_name" with "child"
          And I select "Here is a test page" from "symedit_page_basic_parent"
          And I press "Create Page"
         Then I should have a page resource with path "/here-is-a-test-page/child"

    Scenario: Homepage should not have parent, slug, or delete button
        Given I am on the admin dashboard page
         When I follow "List Pages"
          And I follow "Home"
         Then I should not see "Parent"
          And I should not see "Name"
          And I should not see "Delete Page"
