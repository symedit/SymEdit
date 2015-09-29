@sitemap
Feature: Website Sitemap
    In order to index the site
    As a search engine robot
    I want to be able to see the sitemap

    Scenario: Viewing Sitemap
        Given I am on the sitemap page
         Then the sitemap should have urls:
         """
         /
         /about
         /blog/
         /events/
         /contact
         /blog/hello-world
         /blog/category/general
         """
