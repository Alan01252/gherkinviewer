<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alan
 * Date: 02/03/14
 * Time: 12:45
 * To change this template use File | Settings | File Templates.
 */
namespace GherkinViewer\services;


use GherkinViewer\exceptions\FeatureNotFoundException;

class FeatureFinder
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

    private function findFilesInFolder()
    {
        return glob($this->directory . '/*.{feature}', GLOB_BRACE);
    }

    public function findByTitle($featureTitle)
    {
        $files = $this->findFilesInFolder();
        foreach ($files as $file) {
            $feature = $this->parser->parseFeature(file_get_contents($file));
            $title = $feature->getTitle();
            if ($title === $featureTitle) {
                return $feature;
            }
        }

        throw new FeatureNotFoundException("Feature {$featureTitle} not found");
    }

    public function findAllFeatureTitles()
    {
        $features = [];

        $files = $this->findFilesInFolder();
        foreach ($files as $file) {
            $features[] = $this->parser->parseFeature(file_get_contents($file))->getTitle();
        }

        return $features;
    }
}