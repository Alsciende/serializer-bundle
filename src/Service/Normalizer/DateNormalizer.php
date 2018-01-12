<?php

namespace Alsciende\SerializerBundle\Service\Normalizer;

/**
 * Description of DateNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DateNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    const FORMAT = '!Y-m-d';

    public function supports ()
    {
        return 'date';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array  $data
     * @return \DateTime
     */
    public function normalize ($className, $fieldName, $data)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data);

        return isset($rawValue) ? \DateTime::createFromFormat(self::FORMAT, $rawValue) : null;
    }

    public function isEqual ($a, $b)
    {
        return $a == $b;
    }
}