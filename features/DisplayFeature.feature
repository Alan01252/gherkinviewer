Feature: I want to display features on a web page for other people to view

  Background: I've navigated to a page which displays features
    Given this file as a feature
    And I am on "/"

  Scenario: I want to see a scenario with some text
    Then I should see the contents of this feature
    And I should see
    """
    This text rendered beautifully.
    As well as this text.
    """

  Scenario Outline: I want to easily see what's a keyword and what's not
    Then I should see the word <word> in <colour>
  Examples:
    | word             | colour |
    | Background       | blue   |
    | Feature          | blue   |
    | Scenario         | blue   |
    | Scenario Outline | blue   |
    | Given            | blue   |
    | And              | blue   |
    | Then             | blue   |
    | Examples         | blue   |
