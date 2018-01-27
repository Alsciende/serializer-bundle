<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Exception\UnknownTypeException;
use Alsciende\SerializerBundle\Model\Fragment;
use Alsciende\SerializerBundle\Service\Normalizer\NormalizerInterface;

/**
 * Description of NormalizerManager
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class NormalizerService
{
    /** @var NormalizerInterface[] $normalizers */
    private $normalizers;

    /**
     * NormalizerManager constructor.
     * @param NormalizerInterface[] $normalizers
     */
    public function __construct ($normalizers)
    {
        foreach ($normalizers as $normalizer) {
            $this->normalizers[$normalizer->supports()] = $normalizer;
        }
    }

    /**
     * @param Fragment $fragment
     * @return Fragment
     */
    public function normalize (Fragment $fragment): Fragment
    {
        return $fragment->setNormalizedData(
            $this->getNormalizedData(
                $fragment->getBlock()->getSource()->getClassName(),
                $fragment->getBlock()->getSource()->getProperties(),
                $fragment->getRawData()
            )
        );
    }

    /**
     * @param string $className
     * @param array $propertyMap
     * @param array $data
     * @return array
     */
    public function getNormalizedData (string $className, array $propertyMap, array $data): array
    {
        $result = [];

        foreach ($propertyMap as $property => $type) {
            $result[$property] = $this->getNormalizer($type)->normalize($className, $property, $data);
        }

        return $result;
    }

    /**
     * @param string $type
     * @return NormalizerInterface
     * @throws UnknownTypeException
     */
    public function getNormalizer (string $type): NormalizerInterface
    {
        $normalizer = $this->normalizers[$type];
        if (!$normalizer instanceof NormalizerInterface) {
            throw new UnknownTypeException($type);
        }

        return $normalizer;
    }
}