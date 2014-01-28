<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * @var String the contents of a feature file
     */
    private $feature;


    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Given /^this file as a feature$/
     */
    public function thisFileAsAFeature()
    {
        $feature = file_get_contents(__DIR__ . "/../DisplayFeature.feature");
        if ($feature !== false) {
            return true;
        }

        throw new \Exception("Unable to load feature file");

    }

    /**
     * @When /^I navigate to "([^"]*)"$/
     */
    public function iNavigateTo($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should see the contents of this feature$/
     */
    public function iShouldSeeTheContentsOfThisFeature()
    {
        throw new PendingException();
    }
}
