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
     * @param array $data
     * @param string $columnName
     */
    public function __construct ($data, $columnName)
    {
        $this->data = $data;
        $this->columnName = $columnName;
        parent::__construct(sprintf('Missing property [%s] in data.', $columnName));
    }
}
