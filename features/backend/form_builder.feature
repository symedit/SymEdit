@form_builder
Feature: Form Builder Backend
    In order to manage forms and form elements
    As an administrator
    I want to be able to list, view, edit and create forms and form elements

    Background:
        Given I am logged in as admin

    Scenario: Seeing index of all forms
        Given I am on the admin dashboard page
         When I follow "List Forms"
         Then I should be on the admin form page
          And I should see 1 form in the list

    Scenario: Listing elements of a form
        Given I am on the admin form page
         When I follow "Manage Fields"
         Then I should see 4 elements in the list

    Scenario: Creating a new form element
        Given I am on the admin form page
         When I follow "Manage Fields"
          And I follow "Add Form Element"
          And I follow "Text Box"
          And I fill in "Name" with "test-element"
          And I fill in "Label" with "Test Label"
          And I press "Create Element"
         Then I should see "Form element has been successfully created."
          And I should see 5 elements in the list
