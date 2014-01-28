<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @var String the contents of a feature file
     */
    private $feature;

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
     * @Then /^I should see the contents of this feature$/
     */
    public function iShouldSeeTheContentsOfThisFeature()
    {
        $result = strcmp($this->getSession()->getPage()->getContent(), $this->feature);
        if ($result === false) {
            throw new \Exception("Contents of page do not match feature");
        }

        return true;
    }
}
