<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;

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
     * @param array $data
     * @param Field $config
     * @return bool|mixed|null
     * @throws \Alsciende\SerializerBundle\Exception\MissingPropertyException
     */
    public function normalize (string $className, string $fieldName, array $data, Field $config)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data, $config);

        return isset($rawValue) ? boolval($rawValue) : null;
    }

    public function isEqual ($a, $b)
    {
        return $a === $b;
    }
}