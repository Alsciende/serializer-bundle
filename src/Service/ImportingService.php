<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;
use Alsciende\SerializerBundle\Model\Source;
use Psr\Log\LoggerInterface;

/**
 * Description of Serializer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ImportingService
{
    /** @var LoggerInterface $logger */
    private $logger;

    /** @var ScanningService $scanningService */
    private $scanningService;

    /** @var StoringService $storingService */
    private $storingService;

    /** @var EncodingService $encodingService */
    private $encodingService;

    /** @var NormalizerManager $normalizerManager */
    private $normalizerManager;

    /** @var MetadataService $metadataService */
    private $metadataService;

    public function __construct (
        ScanningService $scanningService,
        StoringService $storingService,
        EncodingService $encodingService,
        NormalizerManager $normalizerManager,
        MetadataService $metadataService
    )
    {
        $this->scanningService = $scanningService;
        $this->storingService = $storingService;
        $this->encodingService = $encodingService;
        $this->normalizerManager = $normalizerManager;
        $this->metadataService = $metadataService;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger (LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     *
     * @param Source $source
     * @param string $defaultPath
     * @return Fragment[]
     */
    public function importSource (Source $source, string $defaultPath)
    {
        $result = [];
        foreach ($this->storingService->retrieveBlocks($source, $defaultPath) as $block) {
            if ($this->logger instanceof LoggerInterface) {
                $this->logger->info('Successfully imported block', ['path' => $block->getPath()]);
            }

            $result = array_merge($result, $this->importBlock($block));
        }

        return $result;
    }

    /**
     *
     * @param Block $block
     * @return Fragment[]
     */
    public function importBlock (Block $block)
    {
        $result = [];
        foreach ($this->encodingService->decode($block) as $fragment) {
            if ($this->logger instanceof LoggerInterface) {
                $this->logger->debug('Successfully decoded fragment', $fragment->getData());
            }

            $result[] = $this->importFragment($fragment);
        }

        return $result;
    }

    /**
     *
     * @param Fragment $fragment
     * @return Fragment
     */
    public function importFragment (Fragment $fragment)
    {
        $className = $fragment->getBlock()->getSource()->getClassName();

        $fragment->setNormalizedData($this->normalizerManager->normalize(
            $className,
            $fragment->getBlock()->getSource()->getProperties(),
            $fragment->getData()
        ));

        return $fragment->setEntity($this->metadataService->hydrate($className, $fragment->getNormalizedData()));
    }
}
