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
     * @var The folder containing the features
     */
    private $featureFolder;

    /**
     * @Given /^this file as a feature$/
     */
    public function thisFileAsAFeature()
    {
        $this->feature = file_get_contents(__DIR__ . "/../DisplayFeature.feature");
        if ($this->feature !== false) {
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
        if ($result === 0) {
            throw new \Exception("Contents of page do not match feature");
        }

        return true;
    }

    /**
     * @Given /^the format should be the same as this$/
     */
    public function theFormatShouldBeTheSameAsThis()
    {
        if (nl2br($this->feature) === $this->getSession()->getPage()->getContent()) {
            return true;
        }

        throw new \Exception("Feature wasn't as expected");
    }

    /**
     * @Then /^I should see the word "([^"]*)" in "([^"]*)"$/
     */
    public function iShouldSeeTheWordIn($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I should see$/
     */
    public function iShouldSee(PyStringNode $string)
    {
        $content = $this->getSession()->getPage()->getContent();
        $lines = $string->getLines();
        $count = count($lines);

        $found = 0;
        foreach ($lines as $line) {
            if (strstr($content, $line) !== false) {
                $found++;
            }
        }

        if ($found === $count) {
            return true;
        }

        throw new \Exception("Pytext was not found");
    }


    /**
     * @Then /^I should see a table which looks like$/
     */
    public function iShouldSeeATableWhichLooksLike(TableNode $table)
    {
        $DOM = new DOMDocument;
        $DOM->loadHTML($this->getSession()->getPage()->getContent());

        $domTables = $DOM->getElementsByTagName('table');
        foreach ($domTables as $domTable) {
            $foundTable = $this->domTableToHash($domTable);

            if ($this->diffMulti($foundTable, $table->getHash())) {
                return true;
            }

        }

        throw new \Exception("Unable to find matching table");
    }

    private function diffMulti($array1, $array2)
    {

        foreach ($array1 as $key => $val) {
            if (isset($array2[$key])) {
                if (is_array($val) && is_array($array2[$key])) {
                    return $this->diffMulti($val, $array2[$key]);
                }
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Converts DOM Table to Hash to allow us to do an easy comparison check
     *
     * @param $table
     * @return array
     */
    private function domTableToHash($table)
    {

        $hash = [];
        $headers = [];
        foreach ($table->getElementsByTagName('th') as $th) {
            $headers[] = $th->nodeValue;
        }

        $headersCount = count($headers);

        $i = 0;
        $headerKey = 1;

        foreach ($table->getElementsByTagName('td') as $td) {

            $hash[$i][$headers[$headerKey - 1]] = $td->nodeValue;

            if ($headerKey == $headersCount) {
                $i++;
                $headerKey = 1;
            } else {
                $headerKey++;
            }
        }

        return $hash;

    }

    /**
     * @Then /^I should see a table which contains "([^"]*)" "([^"]*)"$/
     */
    public function iShouldSeeATableWhichContains($arg1, $arg2)
    {
        $DOM = new DOMDocument;
        $DOM->loadHTML($this->getSession()->getPage()->getContent());
        $xpath = new DOMXPath($DOM);

        if ($xpath->query("//td[text()='$arg1']")->length >= 1 && $xpath->query("//td[text()='$arg2']")->length >= 1) {
            return true;
        }

        throw new Exception("Unable to find td with matching content");
    }

    /**
     * @Given /^a directory that has a bunch of features$/
     */
    public function aDirectoryThatHasABunchOfFeatures2()
    {
        $this->featureFolder = __DIR__ . "/../";
    }


    /**
     * @Then /^I should see the title of every feature in the features directory$/
     */
    public function iShouldSeeTheTitleOfEveryFeatureInTheFeaturesDirectory()
    {
        $files = glob($this->featureFolder . '*.{feature}', GLOB_BRACE);
        foreach ($files as $file) {
            $contents = file($file);
            $feature = trim(str_replace('Feature:', '', preg_grep('/^Feature/', $contents)[0]));

            if (strstr($this->getSession()->getPage()->getContent(), $feature) === false) {
                throw new \Exception("Feature not found on feature list");
            }
        }
    }

    /**
     * @Given /^I should see this feature$/
     */
    public function iShouldSeeThisFeature()
    {
        throw new PendingException();
    }

}
