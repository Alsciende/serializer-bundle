<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;

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
     * @param Field $config
     * @return mixed|null|string
     * @throws \Alsciende\SerializerBundle\Exception\MissingPropertyException
     */
    public function normalize (string $className, string $fieldName, array $data, Field $config)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data, $config);
        return isset($rawValue) ? strval($rawValue) : null;
    }

    public function isEqual ($a, $b)
    {
        return $a === $b;
    }
}
