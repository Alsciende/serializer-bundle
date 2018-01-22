<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 19/01/18
 * Time: 16:14
 */

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
