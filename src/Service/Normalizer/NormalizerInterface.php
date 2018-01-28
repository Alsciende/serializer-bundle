<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Exception\MissingPropertyException;

interface NormalizerInterface
{
    /**
     * @return string
     */
    public function supports ();

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @param Field $config
     * @return mixed
     * @throws MissingPropertyException
     */
    public function normalize (string $className, string $fieldName, array $data, Field $config);

    /**
     * @param mixed $a
     * @param mixed $b
     * @return bool
     */
    public function isEqual ($a, $b);
}
