<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;

/**
 * Description of IntegerNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class IntegerNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    public function supports()
    {
        return 'integer';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @param Field $config
     * @return int|mixed|null
     * @throws \Alsciende\SerializerBundle\Exception\MissingPropertyException
     */
    public function normalize(string $className, string $fieldName, array $data, Field $config)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data, $config);

        return isset($rawValue) ? intval($rawValue) : null;
    }

    public function isEqual($a, $b)
    {
        return $a === $b;
    }
}
