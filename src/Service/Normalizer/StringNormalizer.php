<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 19/01/18
 * Time: 16:13
 */

namespace Alsciende\SerializerBundle\Service\Normalizer;
use Alsciende\SerializerBundle\Exception\MissingPropertyException;

/**
 */
class StringNormalizer extends AbstractNormalizer
{
    /**
     * @param $className
     * @param $fieldName
     * @param $data
     * @return string
     * @throws MissingPropertyException
     */
    public function normalize ($className, $fieldName, $data)
    {
        $columnName = $this->metadata->getColumnName($className, $fieldName);

        if (!in_array($columnName, $data)) {
            throw new MissingPropertyException($data, $columnName);
        }

        return strval($data[$columnName]);
    }
}
