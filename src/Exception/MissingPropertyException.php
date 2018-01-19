<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 19/01/18
 * Time: 16:29
 */

namespace Alsciende\SerializerBundle\Exception;

/**
 */
class MissingPropertyException extends \Exception
{
    /** @var array */
    private $data;

    /** @var string */
    private $columnName;

    /**
     * MissingPropertyException constructor.
     * @param $data
     * @param $columnName
     */
    public function __construct ($data, $columnName)
    {
        $this->data = $data;
        $this->columnName = $columnName;
        parent::__construct('Missing property in data.');
    }
}
