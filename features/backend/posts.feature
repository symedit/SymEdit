@posts
Feature: Blog Backend
    In order to manage the blog
    As a store owner
    I want to be able to list, view, edit and create blog posts

    Background:
        Given I am logged in as admin

    Scenario: Seeing index of all posts
        Given I am on the admin dashboard page
         When I follow "List Posts"
         Then I should be on the admin post page
          And I should see 1 post in the list

    Scenario: Accessing post create form
        Given I am on the admin dashboard page
         When I follow "New Post"
         Then I should be on the admin post create page
          And I should see "Create a new blog post"

    Scenario: Creating a simple post
        Given I am on the admin post create page
         When I fill in "symedit_post_basic_title" with "Here is a test post"
          And I press "Create Post"
         Then I should have a post resource with slug "here-is-a-test-post"
