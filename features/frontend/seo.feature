@seo
Feature: SEO
    In order to rank well in search engines
    Content should have custom SEO

    Scenario: Viewing Regular CMS Page
        Given I am on the homepage
         Then I should see a meta description with "Welcome to SymEdit"

    Scenario: Custom Post SEO
        Given I am on "/blog/hello-world"
         Then I should see a meta description with "SEO Description"
          And I should see a title tag with "SEO Title"