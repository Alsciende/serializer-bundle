<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;

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
     * @param array $data
     * @param Field $config
     * @return bool|\DateTime|mixed|null
     * @throws \Alsciende\SerializerBundle\Exception\MissingPropertyException
     */
    public function normalize (string $className, string $fieldName, array $data, Field $config)
    {
        $rawValue = $this->getRawValue($className, $fieldName, $data, $config);

        return isset($rawValue) ? \DateTime::createFromFormat(self::FORMAT, $rawValue) : null;
    }

    public function isEqual ($a, $b)
    {
        return $a == $b;
    }
}