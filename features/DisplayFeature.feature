Feature: I want to display features on a web page for other people to view

  Scenario: A customer navigates to a web page and sees this feature
    Given this file as a feature
    When I navigate to "/"
    Then I should see the contents of this feature