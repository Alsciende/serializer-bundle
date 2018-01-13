<?php

namespace Alsciende\SerializerBundle\Scan;

use Alsciende\SerializerBundle\Doctrine\ObjectManager;
use Alsciende\SerializerBundle\Model\Source;
use Doctrine\Common\Annotations\Reader;
use Psr\Cache\CacheItemPoolInterface;
use ReflectionClass;
use ReflectionProperty;

/**
 * This Service finds all Sources declared in the application
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ScanningService
{

    /** @var ObjectManager $objectManager */
    private $objectManager;

    /** @var SourceOrderingService $orderingService */
    private $orderingService;

    /** @var Reader $reader */
    private $reader;

    /** @var CacheItemPoolInterface $cache */
    private $cache;

    /** @var string|null $path */
    private $path;

    public function __construct (
        ObjectManager $objectManager,
        SourceOrderingService $orderingService,
        Reader $reader,
        CacheItemPoolInterface $cache
    ) {
        $this->objectManager = $objectManager;
        $this->orderingService = $orderingService;
        $this->reader = $reader;
        $this->cache = $cache;
    }

    /**
     * @param null $path
     * @return Source[]
     */
    public function findSources ($path = null)
    {
        $this->path = $path;

        $sources = [];

        foreach ($this->objectManager->getAllManagedClassNames() as $className) {
            if ($source = $this->buildFromClass($className)) {
                $sources[] = $source;
            }
        }

        return $this->orderingService->orderSources($sources);
    }

    /**
     *
     * @param string $className
     * @return Source|null
     */
    private function buildFromClass ($className)
    {
        $cacheKey = $this->getCacheKey($className);
        $cacheItem = $this->cache->getItem($cacheKey);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $reflectionClass = new ReflectionClass($className);
        $annotation = $this->reader->getClassAnnotation($reflectionClass, \Alsciende\SerializerBundle\Annotation\Source::class);
        if ($annotation instanceof \Alsciende\SerializerBundle\Annotation\Source) {
            $source = $this->buildSource($annotation, $reflectionClass);
            $cacheItem->set($source);

            return $source;
        }

        return null;
    }

    private function buildSource (\Alsciende\SerializerBundle\Annotation\Source $annotation, \ReflectionClass $reflectionClass)
    {
        $path = $annotation->path ?: $this->path;
        $source = new Source($reflectionClass->getName(), $path, $annotation->break);

        /* @var $reflectionProperty ReflectionProperty */
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $annotation = $this->reader->getPropertyAnnotation($reflectionProperty, \Alsciende\SerializerBundle\Annotation\Source::class);
            if ($annotation && isset($annotation->type)) {
                $source->addProperty($reflectionProperty->name, $annotation->type);
            }
        }

        return $source;
    }

    private function getCacheKey ($className)
    {
        return "alsciende_serializer.source." . strtr($className, '\\', '_');
    }

}
