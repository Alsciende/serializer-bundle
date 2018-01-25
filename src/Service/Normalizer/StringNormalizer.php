<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

/**
 */
class StringNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function supports ()
    {
        return 'string';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @return string
     */
    public function normalize ($className, $fieldName, $data)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data);
        return isset($rawValue) ? strval($rawValue) : null;
    }

    public function isEqual ($a, $b)
    {
        return $a === $b;
    }
}
