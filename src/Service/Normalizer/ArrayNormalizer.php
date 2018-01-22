<?php

namespace Alsciende\SerializerBundle\Service\Normalizer;

/**
 * Description of ArrayNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ArrayNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    public function supports ()
    {
        return 'array';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @return array
     */
    public function normalize ($className, $fieldName, $data)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data);

        return isset($rawValue) ? $rawValue : [];
    }

    public function isEqual ($a, $b)
    {
        return $a === $b;
    }
}