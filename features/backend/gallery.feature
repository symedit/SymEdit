@gallery
Feature: Gallery Item Backend
    In order to manage the image galleries
    As an administrator
    I want to be able to list, view, edit and create image galleries

    Background:
        Given I am logged in as admin

    Scenario: Seeing index of all galleries
        Given I am on the admin dashboard page
         When I follow "Galleries"
         Then I should be on the admin image gallery page
          And I should see "You currently have no galleries"

    Scenario: Creating an image gallery
        Given I am on the admin image gallery page
         When I follow "Create New Gallery"
          And I fill in "symedit_image_gallery_title" with "New Gallery"
          And I press "Create Gallery"
         Then I should see "Image gallery has been successfully created."
