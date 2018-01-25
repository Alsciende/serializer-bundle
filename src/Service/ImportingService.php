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

    /** @var ScanningService $scanner */
    private $scanner;

    /** @var StoringService $storer */
    private $storer;

    /** @var EncodingService $encoder */
    private $encoder;

    /** @var NormalizerService $normalizer */
    private $normalizer;

    /** @var HydrationService $hydrator */
    private $hydrator;

    public function __construct (
        ScanningService $scanningService,
        StoringService $storingService,
        EncodingService $encodingService,
        NormalizerService $normalizerService,
        HydrationService $hydrationService
    ) {
        $this->scanner = $scanningService;
        $this->storer = $storingService;
        $this->encoder = $encodingService;
        $this->normalizer = $normalizerService;
        $this->hydrator = $hydrationService;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger (LoggerInterface $logger): self
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
    public function importSource (Source $source, string $defaultPath): array
    {
        $result = [];
        foreach ($this->storer->retrieveBlocks($source, $defaultPath) as $block) {
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
    public function importBlock (Block $block): array
    {
        $result = [];
        foreach ($this->encoder->decode($block) as $fragment) {
            if ($this->logger instanceof LoggerInterface) {
                $this->logger->debug('Successfully decoded fragment', $fragment->getRawData());
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
    public function importFragment (Fragment $fragment): Fragment
    {
        return $this->hydrator->hydrate($this->normalizer->normalize($fragment));
    }
}
