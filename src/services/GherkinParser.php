<?php
namespace GherkinViewer\services;

use Behat\Gherkin\Keywords\ArrayKeywords;
use Behat\Gherkin\Lexer;
use Behat\Gherkin\Parser;

class GherkinParser
{
    public function __construct()
    {
        $keywords = new ArrayKeywords([
            'en' => [
                'feature' => 'Feature',
                'background' => 'Background',
                'scenario' => 'Scenario',
                'scenario_outline' => 'Scenario Outline|Scenario Template',
                'examples' => 'Examples|Scenarios',
                'given' => 'Given',
                'when' => 'When',
                'then' => 'Then',
                'and' => 'And',
                'but' => 'But'
            ]
        ]);

        $this->lexer = new Lexer($keywords);
        $this->parser = new Parser($this->lexer);
    }

    /**
     * @param $feature
     * @return string
     */
    public function parseFeature($feature)
    {
        $parsedFeature = $this->parser->parse($feature);

        return $parsedFeature;
    }
}
