<?php
namespace GherkinViewer\services;


class FeatureExtractor
{
    /**
     * @var String
     */
    private $directory;

    /**
     * @var GherkinParser
     */
    private $parser;

    public function __construct($directory, GherkinParser $parser)
    {

        $this->directory = $directory;
        $this->parser = $parser;
    }

    public function getFeatures()
    {
        $features = [];

        $files = glob($this->directory . '/*.{feature}', GLOB_BRACE);
        foreach ($files as $file) {
            $features[] = $this->parser->parseFeature(file_get_contents($file))->getTitle();
        }

        return $features;
    }
}