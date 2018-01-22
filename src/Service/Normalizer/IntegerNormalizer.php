<?php

namespace Alsciende\SerializerBundle\Service\Normalizer;

/**
 * Description of IntegerNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class IntegerNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    public function supports ()
    {
        return 'integer';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @return integer
     */
    public function normalize ($className, $fieldName, $data)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data);

        return isset($rawValue) ? intval($rawValue) : null;
    }

    public function isEqual ($a, $b)
    {
        return $a === $b;
    }
}