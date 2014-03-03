Feature: Display list of features to allow navigation between features

  Background:
    Given a directory that has a bunch of features

  Scenario: I am a customer and I want to see all the features I have
    Given I am on "/features"
    Then I should see the title of every feature in the features directory

  Scenario: I am a customer and I want to view a specific feature
    Given I am on "/features"
    And I follow "Display list of features to allow navigation between features"
    Then I should be on "/feature/Display list of features to allow navigation between features"
