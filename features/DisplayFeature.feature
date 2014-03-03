Feature: I want to display features on a web page for other people to view

  Background: I've navigated to a page which displays features
    Given this file as a feature
    And I am on "/feature/I want to display features on a web page for other people to view"

  Scenario: I want to see a scenario with some text
    Then I should see the contents of this feature
    And I should see
    """
    This text rendered beautifully.
    As well as this text.
    """

  Scenario: I want to see a scenario with a table
    Then I should see a table which looks like
    | word             | colour | thing |
    | Background       | blue   | red   |
    | Background       | blue   | red   |

  Scenario Outline: I want to see a scenario outline with a table
    Then I should see a table which contains "<word>" "<colour>"
  Examples:
    | word             | colour |
    | Background       | blue   |
    | Feature          | red    |
    | Scenario         | green  |
    | Scenario Outline | orange |
    | Given            | yellow |
    | And              | white  |
    | Then             | black  |
    | Examples         | brown  |
