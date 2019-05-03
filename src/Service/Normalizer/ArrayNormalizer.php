<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;

/**
 * Description of ArrayNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ArrayNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    public function supports()
    {
        return 'array';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @param Field $config
     * @return array|mixed
     * @throws \Alsciende\SerializerBundle\Exception\MissingPropertyException
     */
    public function normalize(string $className, string $fieldName, array $data, Field $config)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data, $config);

        return isset($rawValue) ? $rawValue : [];
    }

    public function isEqual($a, $b)
    {
        return $a === $b;
    }
}
