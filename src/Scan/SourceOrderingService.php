<?php

namespace Alsciende\SerializerBundle\Scan;

use Alsciende\SerializerBundle\Doctrine\ObjectManager;
use Alsciende\SerializerBundle\Model\Source;
use InvalidArgumentException;

/**
 * Description of SourceOrderingService
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class SourceOrderingService
{
    /** @var ObjectManager $objectManager */
    private $objectManager;

    public function __construct (ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Order Sources by dependencies
     * Sources can only depend on Sources before them in the list
     *
     * @param Source[] $sources
     * @return Source[]
     */
    public function orderSources ($sources)
    {
        $ordered = [];
        $classes = [];

        while (count($sources)) {
            $next = $this->findNextResolvedSource($sources, $classes);
            if ($next === null) {
                $unresolvedClasses = array_map(function (Source $source) {
                    return $source->getClassName();
                }, $sources);
                throw new InvalidArgumentException("Sources contain a cycle of dependencies, or a dependency is not configured as a Source.\nUnresolved classes are: " . implode(", ", $unresolvedClasses) . ".\nResolved classes are : " . implode(", ", $classes) . ".");
            }

            $source = $sources[$next];
            $ordered[] = $source;
            $classes[] = $source->getClassName();
            array_splice($sources, $next, 1);
        }

        return $ordered;
    }

    /**
     * Find the first class in $sources that only depends on classes in $classes
     *
     * @param Source[] $sources
     * @param string[] $classes
     * @return integer|null
     */
    private function findNextResolvedSource ($sources, $classes)
    {
        foreach ($sources as $index => $source) {
            $resolved = $this->allTargetEntitiesAreKnown($source->getClassName(), $classes);
            if ($resolved) {
                return $index;
            }
        }

        return null;
    }

    /**
     * Return true if all target entities of $className are listed in $classes
     *
     * @param string $className
     * @param string[] $classes
     * @return boolean
     */
    private function allTargetEntitiesAreKnown ($className, $classes)
    {
        $dependencies = $this->objectManager->getAllTargetClasses($className);
        foreach (array_values($dependencies) as $dependency) {
            if (!in_array($dependency, $classes)) {
                return false;
            }
        }

        return true;
    }

}
