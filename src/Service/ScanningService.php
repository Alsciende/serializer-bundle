<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Annotation\Skizzle;
use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Util\SourceOrderingService;
use Doctrine\Common\Annotations\Reader;

/**
 * This Service finds all Sources declared in the application
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ScanningService
{
    /** @var MetadataService */
    private $metadataService;

    /** @var Reader $reader */
    private $reader;

    public function __construct (
        MetadataService $metadataService,
        Reader $reader
    )
    {
        $this->metadataService = $metadataService;
        $this->reader = $reader;
    }

    /**
     * @return Source[]
     */
    public function findSources (): array
    {
        $sources = [];

        foreach ($this->metadataService->getAllManagedClassNames() as $className) {
            $source = $this->buildFromClass($className);
            if ($source instanceof Source) {
                $sources[] = $source;
            }
        }

        $ordering = new SourceOrderingService($this->metadataService);

        return $ordering->orderSources($sources);
    }

    /**
     *
     * @param string $className
     * @return Source|null
     */
    public function buildFromClass (string $className)
    {
        $reflectionClass = new \ReflectionClass($className);
        $annotation = $this->reader->getClassAnnotation($reflectionClass, Skizzle::class);
        if ($annotation instanceof Skizzle) {
            return $this->buildSource($annotation, $reflectionClass);
        }

        return null;
    }

    /**
     * @param Skizzle          $annotation
     * @param \ReflectionClass $reflectionClass
     * @return Source
     */
    private function buildSource (Skizzle $annotation, \ReflectionClass $reflectionClass): Source
    {
        $source = new Source($reflectionClass->getName(), $annotation->break);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $annotation = $this->reader->getPropertyAnnotation($reflectionProperty, Skizzle\Field::class);
            if ($annotation && isset($annotation->type)) {
                $source->addProperty($reflectionProperty->name, $annotation->type);
            }
        }

        return $source;
    }
}
