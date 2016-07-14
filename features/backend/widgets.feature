@widgets
Feature: Widget Backend
    In order to manage the widgets
    As an administrator
    I want to be able to list, view, edit and create widgets

    Background:
        Given I am logged in as admin

    Scenario: Seeing index of all widgets
        Given I am on the admin dashboard page
         When I follow "List Widgets"
         Then I should be on the admin widget page
          And I should see 2 widgets in the sidebar area
          And I should see 1 widget in the featured area
          And I should see 2 widgets in the supplemental area
          And I should see 2 widgets in the footer area

    Scenario: Choosing a new widget
        Given I am on the admin dashboard page
         When I follow "New Widget"
         Then I should see "Plain HTML"
          And I should see "Basic Contact Information"

    Scenario: Creating a new widget
        Given I am on the admin widget choose page
         When I follow "Plain HTML"
          And I fill in "symedit_widget_basic_name" with "test-widget"
          And I press "Create Widget"
         Then I should see "Widget has been successfully created."
