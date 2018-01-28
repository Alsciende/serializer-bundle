<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Exception\ValidationException;
use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;
use Alsciende\SerializerBundle\Model\Source;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /** @var PersistenceManager $persistence */
    private $persistence;

    /** @var MergingService $merging */
    private $merging;

    /** @var ValidatorInterface $validator */
    private $validator;

    public function __construct (
        ScanningService $scanningService,
        StoringService $storingService,
        EncodingService $encodingService,
        NormalizerService $normalizerService,
        HydrationService $hydrationService,
        PersistenceManager $persistence,
        MergingService $merging,
        ValidatorInterface $validator
    )
    {
        $this->scanner = $scanningService;
        $this->storer = $storingService;
        $this->encoder = $encodingService;
        $this->normalizer = $normalizerService;
        $this->hydrator = $hydrationService;
        $this->persistence = $persistence;
        $this->merging = $merging;
        $this->validator = $validator;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger (LoggerInterface $logger): self
    {
        $this->logger = $logger;
        $this->merging->setLogger($logger);
        $this->scanner->setLogger($logger);

        return $this;
    }

    /**
     * @param string $path
     * @param bool   $usePersistence
     * @throws ValidationException
     */
    public function import (string $path, bool $usePersistence = false)
    {
        $sources = $this->scanner->findSources();

        foreach ($sources as $source) {
            if ($usePersistence) {
                $this->persistence->warmup($source);
            }

            $fragments = $this->importSource($source, $path);

            foreach ($fragments as $fragment) {
                $errors = $this->validator->validate($fragment->getHydratedEntity());
                if (count($errors) > 0) {
                    throw new ValidationException($fragment, $errors);
                }

                if ($usePersistence) {
                    $entity = $this->persistence->findManaged($fragment->getHydratedEntity());
                    $this->merging->merge($entity, $fragment);
                    $this->persistence->persist($entity);
                }
            }

            if ($usePersistence) {
                $this->persistence->commit();
            }
        }
    }

    /**
     * @param Source $source
     * @param string $path
     * @return Fragment[]
     */
    public function importSource (Source $source, string $path): array
    {
        $result = [];
        foreach ($this->storer->retrieveBlocks($source, $path) as $block) {
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
