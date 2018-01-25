<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

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
     * @param array  $data
     * @return mixed
     * @throws MissingPropertyException
     */
    public function normalize ($className, $fieldName, $data);

    /**
     * @param mixed $a
     * @param mixed $b
     * @return bool
     */
    public function isEqual ($a, $b);
}
