@settings
Feature: Settings Backend
    In order to manage the settings
    As an administrator
    I want to be able to view and edit settings

    Background:
        Given I am logged in as admin

    Scenario: Navigating to settings
        Given I am on the admin dashboard page
         When I follow "Settings"
         Then I should be on the admin settings page

    Scenario: Saving a setting
        Given I am on the admin settings page
         When I fill in "sylius_settings_company_name" with "test company"
          And I press "Update Settings"
         Then I should see "Settings Saved"

