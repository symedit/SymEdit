@blog
Feature: CMS Homepage
    In order to read the blog
    As a visitor
    I want to be able to see the most recent posts

    Scenario: Viewing Blog Index
        Given I am on the blog index
         Then I should see "My Blog"
          And I should see 3 recent posts

    Scenario: Viewing A Blog Post
        Given I am on the blog index
         When I follow "Hello World!"
         Then I should see "Here is your first blog post!"

    Scenario: Viewing a Blog Category
        Given I am on the blog index
         When I follow "General"
         Then I should see "Hello World!"

    Scenario: A Post should have SEO
        Given I am on the blog index
         When I follow "Hello World!"
         Then I should see a title tag with "SEO Title"