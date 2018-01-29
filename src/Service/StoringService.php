<?php
declare(strict_types=1);

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
     * @return Block[]
     */
    public function retrieveBlocks(Source $source, string $basePath): array
    {
        $parts = explode('\\', $source->getClassName());
        $path = $basePath . "/" . array_pop($parts);

        $source->hasBreak() ? $this->scanDirectory($source, $path) : $this->scanFile($source, $path . '.json');

        return $source->getBlocks();
    }

    /**
     * @param Source $source
     * @param string $path
     * @return void
     */
    public function scanDirectory(Source $source, string $path)
    {
        if (file_exists($path) && is_dir($path)) {
            foreach (glob("$path/*.json") as $filename) {
                $this->scanFile($source, $filename);
            }
        }
    }

    /**
     * @param Source $source
     * @param string $path
     * @return void
     */
    public function scanFile(Source $source, string $path)
    {
        if (file_exists($path) && is_file($path)) {
            $source->addBlock(new Block(file_get_contents($path), $path));
        }
    }
}
