Feature: Hello Page
    In order to be greeted nicely
    As a customer
    I expect to be greeted by the page using my name

    Scenario: test the hello page
        Given I am on "/"
        Then I should see "Hello Peter"
