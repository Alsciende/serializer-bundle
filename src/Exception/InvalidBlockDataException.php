<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 15/01/18
 * Time: 13:43
 */

namespace Alsciende\SerializerBundle\Exception;

/**
 */
class InvalidBlockDataException extends \Exception
{
    /** @var mixed $data */
    private $data;

    /**
     * InvalidBlockDataException constructor.
     * @param mixed $data
     */
    public function __construct ($data)
    {
        $this->data = $data;
        parent::__construct('Block data cannot be decoded to a numeric array.');
    }
}
