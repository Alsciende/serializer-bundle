<?php

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Source;

/**
 * Turns a string into a file
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class StoringService
{
    /**
     * Retrieve Blocks from a Source configuration
     *
     * @param Source $source
     * @param string $basePath
     * @return void
     */
    public function retrieveBlocks (Source $source, $basePath)
    {
        $parts = explode('\\', $source->getClassName());
        $path = $basePath . "/" . array_pop($parts);

        $source->hasBreak() ? $this->scanDirectory($source, $path) : $this->scanFile($source, $path.'.json');
    }

    /**
     * @param Source $source
     * @param        $path
     */
    public function scanDirectory (Source $source, $path)
    {
        if (file_exists($path) && is_dir($path)) {
            foreach (glob("$path/*.json") as $filename) {
                $this->scanFile($source, $filename);
            }
        }
    }

    /**
     * @param Source $source
     * @param        $path
     */
    public function scanFile (Source $source, $path)
    {
        if (file_exists($path) && is_file($path)) {
            $source->addBlock(new Block(file_get_contents($path), $path));
        }
    }
}
