<?php

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Exception\MissingPropertyException;
use Alsciende\SerializerBundle\Exception\ReverseSideException;

/**
 * Description of AssociationNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class AssociationNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    public function supports ()
    {
        return 'association';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @return object|null
     */
    public function normalize ($className, $fieldName, $data)
    {
        $associationMapping = $this->metadata->getAssociationMapping($className, $fieldName);

        if ($associationMapping['isOwningSide'] === false) {
            throw new ReverseSideException($fieldName, $className);
        }

        $referenceValues = [];
        foreach ($associationMapping['sourceToTargetKeyColumns'] as $referenceKey => $targetIdentifier) {
            if (!key_exists($referenceKey, $data)) {
                throw new MissingPropertyException($data, $referenceKey);
            }
            $referenceValues[$targetIdentifier] = $data[$referenceKey];
        }

        return $this->metadata->getReference($associationMapping['targetEntity'], $referenceValues);
    }
}