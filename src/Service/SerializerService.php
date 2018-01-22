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

    /** @var NormalizerManager $normalizerManager */
    private $normalizerManager;

    /** @var MetadataService $metadataService */
    private $metadataService;

    public function __construct (
        StoringService $storingService,
        EncodingService $encodingService,
        NormalizerManager $normalizerManager,
        MetadataService $metadataService
    ) {
        $this->storingService = $storingService;
        $this->encodingService = $encodingService;
        $this->normalizerManager = $normalizerManager;
        $this->metadataService = $metadataService;
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
        foreach ($this->storingService->retrieveBlocks($source, $defaultPath) as $block) {
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
     * @return object
     */
    public function importFragment (Fragment $fragment)
    {
        $className = $fragment->getBlock()->getSource()->getClassName();
        $array = $this->normalizerManager->denormalize(
            $className,
            $fragment->getBlock()->getSource()->getProperties(),
            $fragment->getData()
        );

        return $this->metadataService->hydrate($className, $array);
    }
}
