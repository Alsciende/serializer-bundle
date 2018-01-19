<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 19/01/18
 * Time: 16:14
 */

namespace Alsciende\SerializerBundle\Service\Normalizer;

interface NormalizerInterface
{
    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @return mixed
     */
    public function normalize($className, $fieldName, $data);
}
