<?php

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;
use Alsciende\SerializerBundle\Model\Source;

/**
 * Description of Serializer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class SerializerService
{
    /** @var StoringService $storingService */
    private $storingService;

    /** @var EncodingService $encodingService */
    private $encodingService;

    /** @var NormalizingService $normalizingService */
    private $normalizingService;

    /** @var ObjectManager $objectManager */
    private $objectManager;

    public function __construct (
        StoringService $storingService,
        EncodingService $encodingService,
        NormalizingService $normalizingService,
        ObjectManager $objectManager
    ) {
        $this->storingService = $storingService;
        $this->encodingService = $encodingService;
        $this->normalizingService = $normalizingService;
        $this->objectManager = $objectManager;
    }

    /**
     *
     * @param Source $source
     * @param string $defaultPath
     * @return array
     */
    public function importSource (Source $source, $defaultPath)
    {
        $result = [];

        $this->storingService->retrieveBlocks($source, $defaultPath);
        foreach ($source->getBlocks() as $block) {
            $result = array_merge($result, $this->importBlock($block));
        }

        return $result;
    }

    /**
     *
     * @param Block $block
     * @return array
     */
    public function importBlock (Block $block)
    {
        $result = [];
        foreach ($this->encodingService->decode($block) as $fragment) {
            $result[] = $this->importFragment($fragment);
        }

        return $result;
    }

    /**
     *
     * @param Fragment $fragment
     * @return array
     */
    public function importFragment (Fragment $fragment)
    {
        $data = $fragment->getData();
        $className = $fragment->getBlock()->getSource()->getClassName();
        $properties = $fragment->getBlock()->getSource()->getProperties();

        $result = ['data' => $data];

        // find the entity based on the incoming identifier
        $entity = $this->objectManager->findOrCreateObject($data, $className);

        // denormalize the designated properties of the data into an array
        $array = $this->normalizingService->denormalize($data, $className, $properties);
        $result['array'] = $array;
        $result['original'] = $this->getOriginal($entity, $array);

        // update the entity with the values of the denormalized array
        $this->objectManager->updateObject($entity, $array);
        $this->objectManager->mergeObject($entity);
        $result['entity'] = $entity;

        return $result;
    }

    public function getOriginal ($entity, $array)
    {
        $result = [];

        foreach (array_keys($array) as $property) {
            $result[$property] = $this->objectManager->readObject($entity, $property);
        }

        return $result;
    }

}
