<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Util;

use Alsciende\SerializerBundle\Exception\DependencyCycleException;
use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\MetadataService;

/**
 * Description of SourceOrderingService
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class SourceOrderingService
{
    /** @var MetadataService $metadataAdapter */
    private $metadataAdapter;

    /** @var array */
    private $resolvedClassNames;

    public function __construct(MetadataService $metadataAdapter)
    {
        $this->metadataAdapter = $metadataAdapter;
    }

    /**
     * Order Sources by dependencies
     * Sources can only depend on Sources before them in the list
     *
     * @param Source[] $sources
     * @return Source[]
     */
    public function orderSources(array $sources): array
    {
        $resolvedSources = [];
        $this->resolvedClassNames = [];

        while (count($sources) > 0) {
            $next = $this->findNextResolvedSource($sources);
            if ($next === null) {
                throw new DependencyCycleException();
            }

            /** @var Source $source */
            list($source) = array_splice($sources, $next, 1);
            $resolvedSources[] = $source;
            $this->resolvedClassNames[] = $source->getClassName();
        }

        return $resolvedSources;
    }

    /**
     * Find the first class in $sources that does not depend on classes in $sources
     *
     * @param Source[] $sources
     * @return integer|null
     */
    private function findNextResolvedSource(array $sources)
    {
        foreach ($sources as $index => $source) {
            if ($this->allTargetClassesAreResolved($source->getClassName())) {
                return $index;
            }
        }

        return null;
    }

    /**
     * Return true if all target classes of $className are listed in $this->resolvedClassNames
     *
     * @param string $className
     * @return boolean
     */
    private function allTargetClassesAreResolved(string $className): bool
    {
        $targetClasses = $this->metadataAdapter->getAllTargetClasses($className);
        foreach (array_values($targetClasses) as $targetClass) {
            if (!in_array($targetClass, $this->resolvedClassNames)) {
                return false;
            }
        }

        return true;
    }
}
