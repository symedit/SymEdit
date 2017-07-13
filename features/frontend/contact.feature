@contact
Feature: Contact Form
    In order to contact website owner
    As a visitor
    I want to be able to fill out the contact form

    Background:
        Given I am on "/contact"

    Scenario: Forgetting Required Information
         Then I should see "Contact Us Now!"
         When I fill in "Name" with "My Name"
          And I fill in "Email" with "test@test.com"
          And I fill in "Message" with "Here is a message"
          And I press "Send Message"
         Then I should see "This value should not be blank"

    Scenario: Invalid Email Address
         When I fill in "Name" with "My Name"
          And I fill in "Email" with "invalid-email"
          And I fill in "Phone" with "123-123-1234"
          And I fill in "Message" with "Here is a message"
          And I press "Send Message"
          And I should see "This value is not a valid email address."

    Scenario: Successful Submit
         When there are no collected emails
          And I fill in "Name" with "My Name"
          And I fill in "Email" with "test@test.com"
          And I fill in "Phone" with "123-123-1234"
          And I fill in "Message" with "Here is a message"
          And I press "Send Message"
         Then I should see "Your submission has been successfully received."
          And I should see an email of type "form_builder_result"
