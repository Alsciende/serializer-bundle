<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

/**
 * Description of BooleanNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class BooleanNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    public function supports ()
    {
        return 'boolean';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array  $data
     * @return bool
     */
    public function normalize (string $className, string $fieldName, array $data)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data);

        return isset($rawValue) ? boolval($rawValue) : null;
    }

    public function isEqual ($a, $b)
    {
        return $a === $b;
    }
}