Feature: I want to display features on a web page for other people to view

  Background:
    Given this file as a feature
    And I am on "/"

  Scenario: I want to read the feature like I do in a text editor
    Then I should see the contents of this feature
    And the format should be the same as this

  Scenario Outline: : I want to easily see what's a keyword and what's not
    Then I should see the word "<word>" in "<colour>"
  Examples:
    | word             | colour |
    | Feature          | blue   |
    | Scenario         | blue   |
    | Scenario Outline | blue   |
    | Given            | blue   |
    | And              | blue   |
    | Then             | blue   |
    | Examples         | blue   |